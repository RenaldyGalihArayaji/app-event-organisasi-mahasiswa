<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\ReportEvent;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = Role::where('name', 'super admin')->first();

        // Jika pengguna adalah superadmin, ambil semua submission-Report
        if ($role && $user->hasRole('super admin')) {
            $reportEvent = ReportEvent::latest()->get();
        } else {
            // Jika bukan superadmin, ambil submission-Report yang terkait dengan id pengguna
            $reportEvent = ReportEvent::where('user_id', $user->id)->latest()->get();
        }

        return view('master.report.index', ['title' => 'Pengajuan Laporan'], compact('reportEvent'));
    }

    public function create()
    {
        $event = Event::where('user_id', Auth::user()->id)->whereDate('end_date', '<', now())->whereHas('submissionEvent', function ($query) {
            $query->where('submission_status', 'approved');
        })->get();
        return view('master.report.create', ['title' => 'Pengajuan Laporan'], compact('event'));
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'event' => 'required',
            'description' => 'required',
            'deadline' => 'required',
            'document' => 'required|mimes:pdf|max:1048576'
        ], [
            'event.required' => 'Pilih event terlebih dahulu',
            'description.required' => 'Deskripsi harus diisi!',
            'document.required' => 'Dokumen harus diupload!',
            'document.mimes' => 'Dokumen harus berupa file PDF!',
            'document.file' => 'Dokumen harus berupa file!',
            'document.max' => 'Ukuran file dokumen tidak boleh melebihi 1 MB',
            'deadline.required' => 'Batas Tanggal Pengajuan harus diisi!',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            //  upload file
            if ($request->hasFile('document')) {
                $name = $request->file('document');
                $fileName = 'Report' . time() . '.' . $name->getClientOriginalExtension();
                Storage::putFileAs('/public/document_reports', $request->file('document'), $fileName);
            }

            $event = Event::where('user_id', Auth::user()->id)->first();

            ReportEvent::create([
                'user_id' => Auth::user()->id,
                'event' => $event->event_name,
                'organization' => Auth::user()->organization->name,
                'description' => strtolower($request->description),
                'document' => $fileName,
                'deadline' => $request->deadline
            ]);

            Alert::success('Sukses', 'Data Berhasil ditambah!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil ditambah!'
            ]);
        }
    }

    public function show($id)
    {
        $report = ReportEvent::findOrFail($id);
        return view('master.report.show', ['title' => 'Pengajuan Laporan'], compact('report'));
    }

    public function edit($id)
    {
        $report = ReportEvent::findOrFail($id);
        $events = Event::where('user_id', Auth::user()->id)
            ->whereDate('end_date', '<', now())
            ->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            })
            ->where('event_name', '!=', $report->event)
            ->get();

        return view('master.report.edit', ['title' => 'Pengajuan Laporan'], compact('report', 'events'));
    }
    public function update(Request $request, ReportEvent $report)
    {
        $validasi = Validator::make($request->all(), [
            'event' => 'required',
            'description' => 'required',
            'deadline' => 'required',
            'document' => 'mimes:pdf|max:1048576',
        ], [
            'event.required' => 'Pilih event terlebih dahulu',
            'description.required' => 'Deskripsi harus diisi!',
            'document.file' => 'Dokumen harus berupa file!',
            'document.max' => 'Ukuran file dokumen tidak boleh melebihi 1 MB',
            'document.mimes' => 'Format dokumen hanya PDF!',
            'deadline.required' => 'Batas Tanggal Pengajuan harus diisi!',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            if ($request->hasFile('document')) {
                $name = $request->file('document');
                $fileName = '' . time() . '.' . $name->getClientOriginalExtension();
                Storage::putFileAs('/public/document_reports', $name, $fileName);
            } else {
                $fileName = $report->document;
            }


            if ($request->has('note')) {
                $report->update([
                    'note' => $request->note,
                    'status' => $request->status,
                ]);
            } else {
                $report->update([
                    'event' => $request->event,
                    'description' => strtolower($request->description),
                    'document' => $fileName,
                    'created_at' => Carbon::now(),
                    'deadline' => $request->deadline
                ]);
            }


            Alert::success('Sukses', 'Data Berhasil diperbarui!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil diperbarui!'
            ]);
        }
    }

    public function destroy(ReportEvent $report)
    {
        if ($report->document) {
            Storage::delete('/public/document_reports/' . $report->document);
        }

        $report->delete();
        return redirect()->back();
    }

    // Prosess Donwload 
    public function downloadReport($document)
    {
        return response()->download(public_path('storage/document_reports/' . $document));
    }

    public function edit_khusus(ReportEvent $report)
    {
        return view('master.report.edit-khusus', ['title' => 'Pengajuan Laporan'], compact('report'));
    }
    public function update_khusus(Request $request, ReportEvent $report)
    {
        $validasi = Validator::make($request->all(), [
            'note' => 'max:1000',
            'status' => 'required',
            'document' => 'mimes:pdf|max:1048576',
        ], [
            'note.max' => 'Maksimal 1000 karakter',
            'document.mimes' => 'File harus berupa PDF',
            'document.max' => 'Maksimal 1 MB',
            'status.required' => 'Status harus diisi!'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            if ($request->hasFile('document')) {
                $name = $request->file('document');
                $fileName = '' . time() . '.' . $name->getClientOriginalExtension();
                Storage::putFileAs('/public/document_reports', $name, $fileName);
            } else {
                $fileName = $report->document;  // Jika tidak ada file yang diunggah, gunakan nama file yang sudah ada
            }

            $report->update([
                'status' => $request->status,
                'note' => strtolower($request->note),
                'document' => $fileName,
                'created_at' => Carbon::now(),
            ]);

            Alert::success('Sukses', 'Data Berhasil diperbarui!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil diperbarui!'
            ]);
        }
    }
}
