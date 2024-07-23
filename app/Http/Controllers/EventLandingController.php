<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventLandingController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['organization', 'category'])->whereHas('submissionEvent', function ($query) {
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

        // Filter berdasarkan status event
        if ($request->has('event_status') && $request->event_status != 'Filter Event') {
            if ($request->event_status == 'ongoing') {
                $query->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now());
            } elseif ($request->event_status == 'past') {
                $query->whereDate('end_date', '<', now());
            } elseif ($request->event_status == 'upcoming') {
                $query->whereDate('start_date', '>', now())->whereDate('start_date', '<=', now()->addWeeks(2));
            }
        }

        // Pencarian berdasarkan nama event
        if ($request->has('search') && $request->search != '') {
            $query->where('event_name', 'LIKE', '%' . $request->search . '%');
        }

        // Dapatkan hasil query dengan pagination
        $events = $query->latest()->paginate(16);

        // Mengambil daftar unik organisasi dan kategori
        $organizations = Organization::where('name', '!=', 'super admin')->distinct()->pluck('name', 'id');
        $categories = Category::distinct()->pluck('name', 'id');

        return view('landing-sistem.event-all', [
            'title' => 'Semua Event',
            'events' => $events,
            'organizations' => $organizations,
            'categories' => $categories,
        ]);
    }
}
