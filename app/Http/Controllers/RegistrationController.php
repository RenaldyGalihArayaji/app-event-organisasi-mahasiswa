<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Mail\SendEmail;
use App\Models\Registration;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegistrationController extends Controller
{
    // Proses pendaftaran
    public function prosesRegistration(Request $request)
    {
        // Mendapatkan acara yang sesuai dengan ID yang dikirimkan oleh pengguna
        $event = Event::findOrFail($request->event_id);

        // Membuat aturan validasi
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'nim' => 'required',
            'prodi' => 'required',
            'phone' => 'required',
        ];

        // Menambahkan aturan validasi untuk proof_payment jika event berbayar
        if ($event->method_type == 'paid') {
            $rules['proof_payment'] = 'required|mimes:jpg,jpeg,png|max:2048';
        } else {
            $rules['proof_payment'] = 'mimes:jpg,jpeg,png|max:2048';
        }

        // Melakukan validasi
        $validasi = Validator::make($request->all(), $rules, [
            'name.required' => "Nama harus diisi",
            'email.required' => "Email harus diisi",
            'nim.required' => "Nim harus diisi",
            'prodi.required' => "Program Studi harus diisi",
            'phone.required' => "Nomor Telepon harus diisi",
            'proof_payment.required' => "Bukti Pembayaran harus diisi",
            'proof_payment.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'proof_payment.max' => 'Ukuran gambar tidak boleh melebihi 2 MB',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {

            $code = 'REG/' . substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);

            $fileName = null;
            if ($request->hasFile('proof_payment')) {
                $name = $request->file('proof_payment');
                $fileName = 'Payment_' . time() . '.' . $name->getClientOriginalExtension();
                Storage::putFileAs('/public/image-payment', $name, $fileName);
            }

            $registrationData = [
                'event_id' => $event->id,
                'code_registration' => $code,
                'name' => $request->name,
                'nim' => $request->nim,
                'prodi' => $request->prodi,
                'email' => $request->email,
                'phone' => $request->phone
            ];

            // Jika metode pembayaran adalah berbayar, sertakan nama file
            if ($event->method_type == 'paid') {
                $registrationData['proof_payment'] = $fileName;
            }

            // Membuat pendaftaran
            Registration::create($registrationData);

            // Mengurangi kuota peserta
            $event->participant_quota -= 1; // Mengurangi kuota dengan 1 peserta
            $event->save(); // Menyimpan perubahan kuota

            Alert::success('Sukses', 'Pendaftaran Berhasil!!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil ditambah!'
            ]);
        }
    }

    public function index()
    {
        $user = Auth::user();
        $role = Role::where('name', 'super admin')->first();

        // Jika pengguna adalah superadmin, ambil semua event yang sudah disetujui
        if ($role && $user->hasRole('super admin')) {
            $events = Event::with(['category', 'submissionEvent' => function ($query) {
                $query->where('submission_status', 'approved');
            }])
                ->whereHas('submissionEvent', function ($query) {
                    $query->where('submission_status', 'approved');
                })
                ->latest()
                ->get();
        } else {
            // Jika bukan superadmin, ambil event yang terkait dengan id pengguna dan yang sudah disetujui
            $events = Event::with(['category', 'submissionEvent' => function ($query) {
                $query->where('submission_status', 'approved');
            }])
                ->where('user_id', $user->id)
                ->whereHas('submissionEvent', function ($query) {
                    $query->where('submission_status', 'approved');
                })
                ->latest()
                ->get();
        }

        return view('master.participant.index', ['title' => 'Participant'], compact('events'));
    }

    // Halaman Data Peserta Per Event
    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);
        $registrations = Registration::where('event_id', $id)->latest()->get();
        return view('master.participant.show', ['title' => 'Participant Show', 'event' => $event, 'registrations' => $registrations]);
    }
    // Halaman Bukti Pembayaran
    public function proof_payment($id)
    {
        $registrations = Registration::findOrFail($id);
        return view('master.participant.proof_payment', ['title' => 'Participant', 'registrations' => $registrations]);
    }
    // Tampilan Scanner
    public function scanner()
    {
        return view('master.participant.scanner', ['title' => 'Participant']);
    }

    public function destroy($id)
    {
        $data = Registration::findOrFail($id);
        Storage::delete('/public/image-payment/' . $data->proof_payment);
        $data->delete();
        return redirect()->back();
    }
    // Cek Kehadiran Peserta
    public function checkRegistration(Request $request)
    {
        $code = $request->qr_code;
        $event_id = $request->event_id; // Ambil event_id dari request

        // Temukan registrasi yang sesuai dengan kode registrasi dan event ID
        $registration = Registration::with('event')
            ->where('code_registration', $code)
            ->where('event_id', $event_id)
            ->first();

        if ($registration) {
            // Jika status presensi sudah "present", tampilkan pesan "Sudah Presensi"
            if ($registration->attendance_status === 'present') {
                Alert::info('info', 'Anda sudah melakukan presensi sebelumnya!');
                return response()->json(['message' => 'Anda sudah melakukan presensi sebelumnya'], 200);
            }

            // Update status presensi menjadi "present"
            $registration->update([
                'attendance_status' => 'present',
            ]);

            Alert::success('sukses', 'Berhasil Presensi!');
            return response()->json(['message' => 'Presensi berhasil'], 200);
        } else {
            // Cari registrasi tanpa memeriksa event ID
            $registrationWithoutEventCheck = Registration::where('code_registration', $code)->first();
            if ($registrationWithoutEventCheck) {
                // Jika ditemukan registrasi tapi tidak terkait dengan event yang diikuti
                Alert::error('Gagal', 'Data tidak ada di dalam event tersebut!');
                return response()->json(['message' => 'Data tidak ada di dalam event tersebut'], 404);
            } else {
                // Jika tidak ditemukan registrasi sama sekali
                Alert::error('Gagal', 'Data tidak ditemukan!');
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
        }
    }
    // Konfirmasi Email
    public function approveRegistration($id)
    {

        // Temukan registrasi berdasarkan ID
        $registration = Registration::with('event')->findOrFail($id);

        // approve
        $registration->email_status = 'approve';
        $registration->save();

        // Email
        $sendEmail = [
            'code' => $registration->code_registration,
            'name' => $registration->name,
            'subject' => "Pendaftaran Acara " . ucwords($registration->event->event_name),
            'nim' => $registration->nim,
            'prodi' => $registration->prodi,
            'lokasi' => $registration->event->event_venue,
            'start_date' => $registration->event->start_date,
            'end_date' => $registration->event->end_date,
            'title' => $registration->event->event_name,
            'description' => $registration->event->event_description,
            'email' => $registration->email,
            'phone' => $registration->phone,
        ];

        // Generate dan menyimpan gambar QR code
        $qrCodeDirectory = storage_path('app/public/image-QrCode');

        // Buat direktori jika belum ada
        if (!file_exists($qrCodeDirectory)) {
            mkdir($qrCodeDirectory, 0755, true);
        }

        // Generate dan menyimpan gambar QR code dengan latar belakang putih
        $qrCodePath = "{$qrCodeDirectory}/{$registration->code_registration}.png";
        QrCode::format('png')
            ->size(500)
            ->backgroundColor(255, 255, 255) // Warna latar belakang putih (RGB: 255, 255, 255)
            ->margin(10)
            ->generate($sendEmail['code'], $qrCodePath);
        $sendEmail['qrCodePath'] = $qrCodePath;

        // Kirim email
        Mail::to($registration->email)->send(new SendEmail($sendEmail));

        Alert::success('Sukses', 'Email Berhasil dikirim dan Registrasi Disetujui!');
        return redirect()->back();
    }
}
