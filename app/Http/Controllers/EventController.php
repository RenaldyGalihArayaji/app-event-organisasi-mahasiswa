<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\SubmissionEvent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $role = Role::where('name', 'super admin')->first();

        // Jika pengguna adalah superadmin, ambil semua pengajuan
        if ($role && $user->hasRole('super admin')) {
            $event = Event::with(['category', 'organization', 'submissionEvent'])->latest()->get();
        } else {
            // Jika bukan superadmin, ambil event yang terkait dengan id pengguna
            $event = Event::with(['category', 'organization', 'submissionEvent'])->where('user_id', $user->id)->latest()->get();
        }

        return view('master.event.index', ['title' => 'Event'], compact('event'));
    }

    public function create()
    {
        $category = Category::all();
        return view('master.event.create', ['title' => 'Event'], compact('category'));
    }
    public function store(Request $request)
    {
        // Validasi input
        $validasi = Validator::make($request->all(), [
            'event_name' => 'required',
            'category_id' => 'required',
            'event_image' => 'required|mimes:jpg,jpeg,png|max:2048',
            'event_price' => 'required|numeric',
            'method_type' => 'required',
            'activity' => 'required',
            'event_description' => 'required|string',
            'event_venue' => 'required|string',
            'event_speaker' => 'nullable|string',
            'participant_quota' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'submission_funds' => 'required|numeric',
            'document_proposal' => 'required|mimes:pdf|max:10485760',
            'document_rab' => 'required|mimes:pdf|max:10485760', 
            'deadline' => 'required'
        ], [
            'event_name.required' => 'Nama event harus diisi',
            'category_id.required' => 'Kategori event harus dipilih',
            'event_image.required' => 'Gambar event harus diunggah',
            'event_image.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'event_image.max' => 'Ukuran gambar tidak boleh melebihi 2 MB',
            'event_price.numeric' => 'Harga harus berupa angka',
            'event_price.required' => 'Harga event harus diisi',
            'method_type.required' => 'Tipe metode event harus dipilih',
            'activity.required' => 'Aktivitas event harus diisi',
            'event_description.required' => 'Deskripsi event harus diisi',
            'event_venue.required' => 'Tempat event harus diisi',
            'participant_quota.required' => 'Kuota peserta event harus diisi',
            'participant_quota.numeric' => 'Kuota peserta harus berupa angka',
            'participant_quota.min' => 'Kuota peserta harus lebih besar dari 0',
            'start_date.required' => 'Tanggal mulai event harus diisi',
            'start_date.date' => 'Tanggal mulai event harus berupa tanggal yang valid',
            'end_date.required' => 'Tanggal selesai event harus diisi',
            'end_date.date' => 'Tanggal selesai event harus berupa tanggal yang valid',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'submission_funds.required' => 'Dana Pengajuan harus diisi',
            'submission_funds.numeric' => 'Dana Pengajuan harus berupa angka',
            'document_proposal.required' => 'Dokumen proposal harus diupload!',
            'document_proposal.file' => 'Dokumen proposal harus berupa file!',
            'document_proposal.max' => 'Ukuran file dokumen proposal tidak boleh melebihi 10 MB',
            'document_proposal.mimes' => 'Format dokumen proposal hanya PDF!',
            'document_rab.required' => 'Dokumen RAB wajib diupload!',
            'document_rab.file' => 'Dokumen RAB harus berupa file!',
            'document_rab.max' => 'Ukuran file dokumen RAB tidak boleh melebihi 10 MB',
            'document_rab.mimes' => 'Format dokumen RAB hanya PDF!',
            'deadline.required' => 'Deadline Persetujuan harus diisi',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        }

        // Cek apakah ada event yang telah disetujui dengan tanggal dan waktu yang sama
        $existingEvent = Event::where('start_date', '<=', $request->end_date)
            ->where('end_date', '>=', $request->start_date)
            ->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            })
            ->first();

        if ($existingEvent) {
            Alert::info('Peringatan', 'Tanggal dan jam event sudah ada yang menggunakan, silakan ganti tanggal dan jam yang lain.');
            return response()->json([
                'status' => 409,
                'errors' => ['conflict' => 'Tanggal dan jam event sudah ada yang menggunakan, silakan ganti tanggal dan jam yang lain.']
            ]);
        }

        // Upload gambar event
        $fileName = null;
        if ($request->hasFile('event_image')) {
            $file = $request->file('event_image');
            $fileName = 'Event_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('/public/image-events', $file, $fileName);
        }

        // Membuat event baru
        $event = Event::create([
            'user_id' => Auth::user()->id,
            'event_name' => strtolower($request->event_name),
            'category_id' => $request->category_id,
            'organization_id' => Auth::user()->organization->id,
            'event_image' => $fileName,
            'start_date' => date('Y-m-d H:i', strtotime($request->start_date)),
            'end_date' => date('Y-m-d H:i', strtotime($request->end_date)),
            'method_type' => $request->method_type,
            'activity' => $request->activity,
            'event_description' => strtolower($request->event_description),
            'event_venue' => strtolower($request->event_venue),
            'event_speaker' => strtolower($request->event_speaker),
            'participant_quota' => $request->participant_quota,
            'event_price' => $request->event_price,
        ]);

        // Upload dokumen proposal
        $fileNameProposal = null;
        if ($request->hasFile('document_proposal')) {
            $fileProposal = $request->file('document_proposal');
            $fileNameProposal = 'Proposal' . time() . '.' . $fileProposal->getClientOriginalExtension();
            Storage::putFileAs('/public/documents_proposal', $fileProposal, $fileNameProposal);
        }

        // Upload dokumen RAB
        $fileNameRab = null;
        if ($request->hasFile('document_rab')) {
            $fileRab = $request->file('document_rab');
            $fileNameRab = 'RAB' . time() . '.' . $fileRab->getClientOriginalExtension();
            Storage::putFileAs('/public/documents_rab', $fileRab, $fileNameRab);
        }

        // Membuat submission event
        SubmissionEvent::create([
            'user_id' => Auth::user()->id,
            'event_id' => $event->id,
            'submission_funds' => $request->submission_funds,
            'document_proposal' => $fileNameProposal,
            'document_rab' => $fileNameRab,
            'deadline' => $request->deadline
        ]);

        // Mengirim notifikasi sukses
        Alert::success('Sukses', 'Data Berhasil ditambah!');
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil ditambah!'
        ]);
    }

    public function show(string $id)
    {
        $event = Event::with(['category', 'organization'])->findOrFail($id);
        $submission = SubmissionEvent::where('event_id', '=', $event->id)->first();
        return view('master.event.show', ['title' => 'Event Show'], compact('event', 'submission'));
    }

    public function edit(string $id)
    {
        $event = Event::with(['category', 'organization'])->findOrFail($id);
        $submission = SubmissionEvent::where('event_id', '=', $event->id)->first();
        $category = Category::where('id', '!=', $event->category_id)->get(['id', 'name']);
        return view('master.event.edit', ['title' => 'Event Edit'], compact('category', 'event', 'submission'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validasi = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'method_type' => 'required|in:free,paid',
            'activity' => 'required|in:online,offline',
            'event_price' => 'nullable|numeric|min:0',
            'event_speaker' => 'nullable|string|max:255',
            'participant_quota' => 'required|numeric|min:1',
            'event_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2097152',
            'event_venue' => 'required|string|max:500',
            'event_description' => 'required|string|max:5000',
            'submission_funds' => 'required|numeric|min:0',
<<<<<<< HEAD
            'document_proposal' => 'nullable|file|mimes:pdf|max:2048',
            'document_rab' => 'nullable|file|mimes:pdf|max:2048',
=======
            'document_proposal' => 'nullable|file|mimes:pdf|max:10485760',
            'document_rab' => 'nullable|file|mimes:pdf|max:10485760',
            'deadline' => 'required'
>>>>>>> b637e6e34e34fee27dbe198d9ff76b8b3b35e040
        ], [
            'event_name.required' => 'Nama event harus diisi',
            'category_id.required' => 'Kategori event harus dipilih',
            'event_image.required' => 'Gambar event harus diunggah',
            'event_image.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'event_image.max' => 'Ukuran gambar tidak boleh melebihi 2 MB',
            'event_price.numeric' => 'Harga harus berupa angka',
            'event_price.required' => 'Harga event harus diisi',
            'method_type.required' => 'Tipe metode event harus dipilih',
            'activity.required' => 'Aktivitas event harus diisi',
            'event_description.required' => 'Deskripsi event harus diisi',
            'event_venue.required' => 'Tempat event harus diisi',
            'participant_quota.required' => 'Kuota peserta event harus diisi',
            'participant_quota.numeric' => 'Kuota peserta harus berupa angka',
            'participant_quota.min' => 'Kuota peserta harus lebih besar dari 0',
            'start_date.required' => 'Tanggal mulai event harus diisi',
            'start_date.date' => 'Tanggal mulai event harus berupa tanggal yang valid',
            'end_date.required' => 'Tanggal selesai event harus diisi',
            'end_date.date' => 'Tanggal selesai event harus berupa tanggal yang valid',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'submission_funds.required' => 'Dana Pengajuan harus diisi',
            'submission_funds.numeric' => 'Dana Pengajuan harus berupa angka',
            'document_proposal.mimes' => 'Format dokumen proposal hanya PDF!',
            'document_proposal.max' => 'Ukuran file dokumen proposal tidak boleh melebihi 10 MB',
            'document_rab.mimes' => 'Format dokumen RAB hanya PDF!',
<<<<<<< HEAD
            'document_rab.max' => 'Ukuran file dokumen RAB tidak boleh melebihi 1 MB',
=======
            'document_rab.max' => 'Ukuran file dokumen RAB tidak boleh melebihi 10 MB',
            'deadline.required' => 'Deadline Persetujuan harus diisi',
>>>>>>> b637e6e34e34fee27dbe198d9ff76b8b3b35e040
        ]);

        $event = Event::findOrFail($id);
        $submission = SubmissionEvent::where('event_id', $id)->first();


        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            if ($request->hasFile('event_image')) {
                Storage::delete('/public/image-events/' . $event->event_image);
                $name = $request->file('event_image');
                $fileName = 'Event_' . time() . '.' . $name->getClientOriginalExtension();
                $request->file('event_image')->storeAs('/public/image-events', $fileName);
            } else {
                $fileName = $event->event_image;
            }

            $startDate = $request->has('start_date') ? Carbon::parse($request->start_date) : $event->start_date->format('Y-m-d H:i:s');
            $endDate = $request->has('end_date') ? Carbon::parse($request->end_date) : $event->end_date->format('Y-m-d H:i:s');

            $event->update([
                'event_name' => strtolower($request->event_name),
                'category_id' => $request->category_id,
                'event_image' => $fileName,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'method_type' => $request->method_type,
                'activity' => $request->activity,
                'event_description' => strtolower($request->event_description),
                'event_venue' => strtolower($request->event_venue),
                'event_speaker' => strtolower($request->event_speaker),
                'participant_quota' => $request->participant_quota,
                'event_price' => $request->event_price,
            ]);

            // Periksa dan simpan file proposal
            if ($request->hasFile('document_proposal')) {
                $proposalFile = $request->file('document_proposal');
                $proposalFileName = 'Proposal' . time() . '.' . $proposalFile->getClientOriginalExtension();
                $proposalFile->storeAs('public/documents_proposal', $proposalFileName);
            } else {
                $proposalFileName = $submission->document_proposal;
            }

            // Periksa dan simpan file RAB
            if ($request->hasFile('document_rab')) {
                $rabFile = $request->file('document_rab');
                $rabFileName = 'RAB' . time() . '.' . $rabFile->getClientOriginalExtension();
                $rabFile->storeAs('public/documents_rab', $rabFileName);
            } else {
                $rabFileName = $submission->document_rab;
            }

            $submission->update([
                'submission_funds' => $request->submission_funds,
                'document_proposal' => $proposalFileName,
                'document_rab' => $rabFileName,
                'created_at' => now(),
                'deadline' => $request->deadline
            ]);

            Alert::success('Sukses', 'Data Berhasil diperbarui!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil diperbarui!'
            ]);
        }
    }
    public function destroy(Event $event)
    {
        Storage::delete('/public/image-events/' . $event->event_image);
        $event->delete();
        return redirect()->route('event.index');
    }

    public function downloadProposal($documentProposal)
    {
        return response()->download(storage_path('app/public/documents_proposal/' . $documentProposal));
    }

    public function downloadRab($documentRab)
    {
        return response()->download(storage_path('app/public/documents_rab/' . $documentRab));
    }

    public function edit_khusus(Event $event)
    {
        $submission = SubmissionEvent::where('event_id', $event->id)->first();
        return view('master.event.edit-khusus', ['title' => 'Event'], compact('event', 'submission'));
    }

    public function update_khusus(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'submission_note' => 'max:1000',
            'submission_status' => 'required',
        ], [
            'submission_note.max' => 'Catatan tidak boleh lebih dari 1000 karakter!',
            'submission_status.required' => 'Nama Event harus diisi!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }

        $submission = SubmissionEvent::where('event_id', $event->id)->first();

        // Periksa dan simpan file proposal
        if ($request->hasFile('document_proposal')) {
            $proposalFile = $request->file('document_proposal');
            $proposalFileName = 'Proposal' . time() . '.' . $proposalFile->getClientOriginalExtension();
            $proposalFile->storeAs('public/documents_proposal', $proposalFileName);
        } else {
            $proposalFileName = $submission->document_proposal;
        }

        // Periksa dan simpan file RAB
        if ($request->hasFile('document_rab')) {
            $rabFile = $request->file('document_rab');
            $rabFileName = 'RAB' . time() . '.' . $rabFile->getClientOriginalExtension();
            $rabFile->storeAs('public/documents_rab', $rabFileName);
        } else {
            $rabFileName = $submission->document_rab;
        }

        $submission->update([
            'submission_status' => $request->submission_status,
            'submission_note' => $request->submission_note,
            'document_proposal' => $proposalFileName,
            'document_rab' => $rabFileName,
        ]);

        Alert::success('Sukses', 'Data Berhasil diperbarui!');
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil diperbarui!'
        ]);
    }
}
