<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Console\Command;

class UpdateEventStatus extends Command
{
    protected $signature = 'event:update-status';
    protected $description = 'Update status of events based on end date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        Event::where('end_date', '<', $now)
            ->where('event_status', 'active')
            ->update(['event_status' => 'inactive']);

        $this->info('Event statuses have been updated.');
    }
}
