<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ParticipantExport implements FromView
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $event = Event::findOrFail($this->id);
        $data = Registration::with('event')->where('event_id', $event->id)->latest()->get();
        return view('master.participant.export', ['event' => $event, 'data' => $data]);
    }
}
