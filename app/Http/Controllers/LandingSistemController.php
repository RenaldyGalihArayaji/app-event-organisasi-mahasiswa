<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Category;
use App\Models\Organization;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Documentation;

class LandingSistemController extends Controller
{
    // Beranda
    public function index(Request $request)
    {
        // Menampilkan Event Terbaru
        $query = Event::with(['organization', 'submissionEvent' => function ($query) {
            $query->where('submission_status', 'approved');
        }])->whereDate('end_date', '>=', now())->whereHas('submissionEvent', function ($query) {
            $query->where('submission_status', 'approved');
        });

        // Menampilkan Jumlah Event
        $eventCount = Event::with(['organization', 'submissionEvent' => function ($query) {
            $query->where('submission_status', 'approved');
        }])->count();

        // Menampilkan Jumlah Organisasi
        $organizationCount = Organization::where('name', '!=', 'super admin')->count();

        // Menampilakan Jumlah Peserta
        $registration = Registration::count();

        // Ambil tanggal hari ini
        $today = Carbon::today();

        // Mulai query untuk mengambil event yang 'inactive'
        $pastEvent = Event::whereDate('end_date', '<', now())->with(['organization', 'category', 'documentation'])->whereHas('submissionEvent', function ($query) {
            $query->where('submission_status', 'approved');
        })->latest()->paginate(3);

        // Ambil tanggal dua minggu dari sekarang
        $twoWeeksFromNow = Carbon::today()->addWeeks(2);

        // Query untuk event yang akan datang dalam dua minggu
        $upcomingEvent = Event::whereDate('start_date', '>', $today)
            ->whereDate('start_date', '<=', $twoWeeksFromNow)
            ->with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            })->latest()->paginate(3);

        // Query untuk event yang sedang berlangsung hari ini
        $ongoingEvent = Event::whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())
            ->with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            })->latest()->paginate(3);

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != 'Filter Kategori') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        // Filter berdasarkan organisasi
        if ($request->has('organization') && $request->organization != 'Filter Organisasi') {
            $query->whereHas('organization', function ($q) use ($request) {
                $q->where('id', $request->organization);
            });
        }

        // Dapatkan hasil query dengan pagination
        $events = $query->latest()->paginate(9);

        // Mengambil daftar unik organisasi dan kategori
        $organizations = Organization::where('name', '!=', 'super admin')->distinct()->pluck('name', 'id');
        $categories = Category::distinct()->pluck('name', 'id');


        return view('landing-sistem.home', [
            'title' => 'Beranda',
            'events' => $events,
            'eventCount' => $eventCount,
            'registration'  => $registration,
            'organizationCount' => $organizationCount,
            'pastEvent' => $pastEvent,
            'upcomingEvent' => $upcomingEvent,
            'ongoingEvent' => $ongoingEvent,
            'organizations' => $organizations,
            'categories' => $categories
        ]);
    }

    // About
    public function about()
    {
        $organization = Organization::where('name', '!=', 'super admin')->get();
        return view('landing-sistem.about', ['title' => 'Tentang Kami'], compact('organization'));
    }

    // Detail Event
    public function detailEvent(Event $event)
    {
        $relatedEvents = Event::where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->take(4)
            ->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            })->get();

        return view('landing-sistem.detail-event', [
            'title' => 'Detail Event',
            'event' => $event,
            'relatedEvents' => $relatedEvents
        ]);
    }

    // Registrasi
    public function registration($id)
    {
        $event = Event::with(['category', 'user'])->findOrFail($id);
        return view('landing-sistem.registration', ['title' => 'Pendaftaran'], compact('event'));
    }

    // Past Event
    public function pastEvent(Request $request)
    {
        // Mulai query untuk mengambil event yang 'inactive'
        $query = Event::whereDate('end_date', '<', now())->with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
            $query->where('submission_status', 'approved');
        });

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        // Filter berdasarkan organisasi
        if ($request->has('organization') && $request->organization != '') {
            $query->whereHas('organization', function ($q) use ($request) {
                $q->where('id', $request->organization);
            });
        }

        // Pencarian berdasarkan nama event
        if ($request->has('search') && $request->search != '') {
            $query->where('event_name', 'LIKE', '%' . $request->search . '%');
        }

        // Dapatkan hasil query dengan pagination
        $events = $query->latest()->paginate(15);

        // Mengambil daftar unik organisasi dan kategori
        $organizations = Organization::where('name', '!=', 'super admin')->distinct()->pluck('name', 'id');
        $categories = Category::distinct()->pluck('name', 'id');

        // Ambil tanggal hari ini
        $today = Carbon::today();

        // Ambil tanggal dua minggu dari sekarang
        $twoWeeksFromNow = Carbon::today()->addWeeks(2);

        // Query untuk event yang akan datang dalam dua minggu
        $upcomingEvent = Event::whereDate('start_date', '>', $today)
            ->whereDate('start_date', '<=', $twoWeeksFromNow)
            ->with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            })->latest()->paginate(5);

        // Query untuk event yang sedang berlangsung hari ini
        $ongoingEvent = Event::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            })->latest()->paginate(5);

        return view('landing-sistem.past-event', [
            'title' => 'Event Terdahulu',
            'events' => $events,
            'organizations' => $organizations,
            'categories' => $categories,
            'upcomingEvent' => $upcomingEvent,
            'ongoingEvent' => $ongoingEvent
        ]);
    }

    // Ongoing Event
    public function ongoingEvent(Request $request)
    {
        // Ambil tanggal hari ini
        $today = Carbon::today();

        // Query untuk event yang sedang berlangsung hari ini
        $query = Event::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            });

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != 'Filter Kategori') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        // Filter berdasarkan organisasi
        if ($request->has('organization') && $request->organization != 'Filter Organisasi') {
            $query->whereHas('organization', function ($q) use ($request) {
                $q->where('id', $request->organization);
            });
        }

        // Pencarian berdasarkan nama event
        if ($request->has('search') && $request->search != '') {
            $query->where('event_name', 'LIKE', '%' . $request->search . '%');
        }

        // Dapatkan hasil query dengan pagination
        $events = $query->latest()->paginate(15);

        // Mengambil daftar unik organisasi dan kategori
        $organizations = Organization::where('name', '!=', 'super admin')->distinct()->pluck('name', 'id');
        $categories = Category::distinct()->pluck('name', 'id');

        // Ambil tanggal dua minggu dari sekarang
        $twoWeeksFromNow = Carbon::today()->addWeeks(2);

        // Query untuk event yang akan datang dalam dua minggu
        $upcomingEvent = Event::whereDate('start_date', '>', $today)
            ->whereDate('start_date', '<=', $twoWeeksFromNow)
            ->with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            })->latest()->paginate(5);

        // Mulai query untuk mengambil event yang 'inactive'
        $pastEvent = Event::whereDate('end_date', '<', now())->with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
            $query->where('submission_status', 'approved');
        })->latest()->paginate(5);

        return view('landing-sistem.ongoing-event', [
            'title' => 'Event Sedang Berlangsung',
            'events' => $events,
            'organizations' => $organizations,
            'categories' => $categories,
            'upcomingEvent' => $upcomingEvent,
            'pastEvent' => $pastEvent
        ]);
    }

    // Upcoming Event
    public function upcomingEvent(Request $request)
    {
        // Ambil tanggal hari ini
        $today = Carbon::today();

        // Ambil tanggal dua minggu dari sekarang
        $twoWeeksFromNow = Carbon::today()->addWeeks(2);

        // Query untuk event yang akan datang dalam dua minggu
        $query = Event::whereDate('start_date', '>', $today)
            ->whereDate('start_date', '<=', $twoWeeksFromNow)
            ->with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            });

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != 'Filter Kategori') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        // Filter berdasarkan organisasi
        if ($request->has('organization') && $request->organization != 'Filter Organisasi') {
            $query->whereHas('organization', function ($q) use ($request) {
                $q->where('id', $request->organization);
            });
        }

        // Pencarian berdasarkan nama event
        if ($request->has('search') && $request->search != '') {
            $query->where('event_name', 'LIKE', '%' . $request->search . '%');
        }

        // Dapatkan hasil query dengan pagination
        $events = $query->latest()->paginate(15);

        // Mengambil daftar unik organisasi dan kategori
        $organizations = Organization::where('name', '!=', 'super admin')->distinct()->pluck('name', 'id');
        $categories = Category::distinct()->pluck('name', 'id');

        // Query untuk event yang sedang berlangsung hari ini
        $ongoingEvent = Event::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
                $query->where('submission_status', 'approved');
            })->latest()->paginate(5);

        // Mulai query untuk mengambil event yang 'inactive'
        $pastEvent = Event::whereDate('end_date', '<', now())->with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
            $query->where('submission_status', 'approved');
        })->latest()->paginate(5);

        return view('landing-sistem.upcoming-event', [
            'title' => 'Event Akan Datang',
            'events' => $events,
            'organizations' => $organizations,
            'categories' => $categories,
            'ongoingEvent' => $ongoingEvent,
            'pastEvent' => $pastEvent
        ]);
    }

    // Dokumentasi
    public function detailDocumentation($id)
    {
        $event = Event::with('documentation')->findOrFail($id);
        return view('landing-sistem.detail-documentation', ['title' => 'Detail Dokumentasi'], compact('event'));
    }

    // Kalender
    public function landingCalendar()
    {
        $event = Event::with(['organization', 'submissionEvent' => function ($query) {
            $query->where('submission_status', 'approved');
        }])->whereHas('submissionEvent', function ($query) {
            $query->where('submission_status', 'approved');
        })->get();

        return view('landing-sistem.calendar', ['title' => 'Kalender Event'], compact('event'));
    }
}
