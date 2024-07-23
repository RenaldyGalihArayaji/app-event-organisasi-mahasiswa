<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Event;
use App\Models\Pengajuan;
use App\Models\ReportEvent;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use App\Models\SubmissionEvent;
use App\Models\SubmissionReport;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = Role::where('name', 'super admin')->first();
        $events = Event::with(['category', 'submissionEvent'])->get();
        $eventActive = Event::whereDate('end_date', '>=', now())->whereHas('submissionEvent', function ($query) {
            $query->where('submission_status', 'approved');
        })->count();
        $eventInactive = Event::whereDate('end_date', '<', now())->whereHas('submissionEvent', function ($query) {
            $query->where('submission_status', 'approved');
        })->count();

        //Ambil tanggal hari ini
        $today = Carbon::today();


        if ($role && $user->hasRole('super admin')) {
            $eventActive = Event::whereDate('end_date', '>=', now())->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            })->count();
            $eventInactive = Event::whereDate('end_date', '<', now())->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            })->count();

            $submissionEvent_waiting = SubmissionEvent::where('submission_status', '=', 'waiting')->count();
            $submissionEvent_approved = SubmissionEvent::where('submission_status', '=', 'approved')->count();
            $submissionEvent_rejected = SubmissionEvent::where('submission_status', '=', 'rejected')->count();

            $report_waiting = ReportEvent::where(['status' => 'waiting'])->count();
            $report_approved = ReportEvent::where(['status' => 'rejected'])->count();
            $report_rejected = ReportEvent::where(['status' => 'approved'])->count();

            // Query untuk event yang sedang berlangsung hari ini
            $ongoingEvent = Event::whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->with(['organization', 'category'])->whereHas('submissionEvent', function ($ongoingEvent) {
                    $ongoingEvent->where('submission_status', 'approved');
                })->latest()->paginate(5);
        } else {
            $eventActive = Event::where(['user_id' => $user->id])->whereDate('end_date', '>=', now())->count();
            $eventInactive = Event::where(['user_id' => $user->id])->whereDate('end_date', '<', now())->count();

            $submissionEvent_waiting = SubmissionEvent::where(['submission_status' => 'waiting', 'user_id' => $user->id])->count();
            $submissionEvent_rejected = SubmissionEvent::where(['submission_status' => 'rejected', 'user_id' => $user->id])->count();
            $submissionEvent_approved = SubmissionEvent::where(['submission_status' => 'approved', 'user_id' => $user->id])->count();

            $report_waiting = ReportEvent::where(['status' => 'waiting', 'user_id' => $user->id])->count();
            $report_approved = ReportEvent::where(['status' => 'rejected', 'user_id' => $user->id])->count();
            $report_rejected = ReportEvent::where(['status' => 'approved', 'user_id' => $user->id])->count();

            // Query untuk event yang sedang berlangsung hari ini
            $ongoingEvent = Event::whereDate('end_date', '>=', now())
                ->where('user_id', $user->id)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->with(['organization', 'category'])->whereHas('submissionEvent', function ($ongoingEvent) {
                    $ongoingEvent->where('submission_status', 'approved');
                })->latest()->paginate(5);
        }

        return view('master.dashboard.index', [
            'title' => 'Dashboard',
            'submissionEvent_waiting' => $submissionEvent_waiting,
            'submissionEvent_approved' => $submissionEvent_approved,
            'submissionEvent_rejected' => $submissionEvent_rejected,
            'events' => $events,
            'eventActive' => $eventActive,
            'eventInactive' => $eventInactive,
            'report_waiting' => $report_waiting,
            'report_approved' => $report_approved,
            'report_rejected' => $report_rejected,
            'ongoingEvent' => $ongoingEvent
        ]);
    }
}
