<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Exports\ParticipantExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportExcel($id)
    {
        $event = Event::findOrFail($id);
        $currentTime = Carbon::now()->format('H-i-s');
        return Excel::download(new ParticipantExport($id), 'data-peserta-' . $event->title . $currentTime . '.xlsx');
    }

    public function exportPdf($id)
    {
        $event = Event::findOrFail($id);
        $registrations = Registration::where('event_id', $id)->get();
        $currentTime = Carbon::now()->format('H-i-s');
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('master.participant.export', ['title' => 'Data Peserta', 'event' => $event, 'data' => $registrations])->setPaper('a4', 'landscape');
        return $pdf->download('data-peserta' . '-' . $currentTime . '.pdf');
    }
}
