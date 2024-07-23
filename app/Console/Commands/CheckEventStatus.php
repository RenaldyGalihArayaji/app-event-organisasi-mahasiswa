<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Console\Command;

class CheckEventStatus extends Command
{
    protected $signature = 'app:check-event-status';
    protected $description = 'Command description';

    public function handle()
    {
        // $currentDate = Carbon::now();
        // $events = Event::where('status', 'active')->get();

        // foreach ($events as $event) {
        //     $startDate = Carbon::parse($event->start_date);
        //     $endDate = Carbon::parse($event->end_date);

        //     if ($currentDate->between($startDate, $endDate)) {
        //         $event->update(['status' => 'active']);
        //     } elseif ($currentDate->gt($endDate)) {
        //         $event->update(['status' => 'inactive']);
        //     }
        // }

        // $this->info('Event status checked and updated successfully.');

        // Ambil semua acara yang sudah berakhir

        // $expiredEvents = Event::where('end_date', '<', Carbon::now())->get();

        // // Perbarui status menjadi "inactive"
        // foreach ($expiredEvents as $event) {
        //     $event->status = 'inactive';
        //     $event->save();
        // }

        // $this->info('Event statuses updated successfully.');
    }
}
