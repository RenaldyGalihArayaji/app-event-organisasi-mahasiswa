<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Sertifikat;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Mail\SendEmailSertifikat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class SertifikatController extends Controller
{
    public function index($id)
    {
        $event = Event::findOrFail($id);
        return view('master.participant.sertifikat', compact('event'));
    }

    public function uploadSertifikat(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'document' => 'required|file|mimes:pdf|max:2048',
        ], [
            'document.required' => 'Dokumen sertifikat harus diisi',
            'document.file' => 'Dokumen sertifikat harus berupa file',
            'document.mimes' => 'Dokumen sertifikat harus berupa PDF',
            'document.max' => 'Dokumen sertifikat maksimal 2MB',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        }

        $event = Event::findOrFail($id);

        if ($request->hasFile('document')) {
            $fileSertifikat = $request->file('document');
            $fileNameSertifikat = 'Sertifikat_' . time() . '.' . $fileSertifikat->getClientOriginalExtension();
            $fileSertifikat->storeAs('public/document_sertifikats', $fileNameSertifikat);
        }

        Sertifikat::create([
            'user_id' => Auth::user()->id,
            'event_id' => $event->id,
            'document' => $fileNameSertifikat
        ]);

        // $registration = Registration::with('event')->where('event_id', $event->id)->first();
        // $sendEmail = [
        //     'code' => $registration->code_registration,
        //     'name' => $registration->name,
        //     'subject' => "Sertifikat " . ucwords($registration->event->event_name),
        //     'nim' => $registration->nim,
        //     'prodi' => $registration->prodi,
        //     'email' => $registration->email,
        //     'phone' => $registration->phone,
        // ];

        // Mail::to($registration->email)->send(new SendEmailSertifikat($sendEmail, $filePath));

        Alert::success('Sukses', 'Berhasil Upload Sertifikat!');
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Upload Sertifikat!'
        ]);
    }
}
