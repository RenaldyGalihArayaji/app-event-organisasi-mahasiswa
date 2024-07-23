<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationLandingController extends Controller
{
    public function index()
    {
        $organizations = Organization::with('user')->where('name', '!=', 'super admin')->latest()->paginate(12);
        return view('landing-sistem.organization-landing', [
            'title' => 'Organisasi El Rahma',
            'organizations' => $organizations
        ]);
    }

    public function organizationEvent(Request $request, $id)
    {
        $organization = Organization::with('events')->findOrFail($id);

        // Query dasar untuk event dengan organisasi terkait dan status 'approved'
        $query = Event::with(['organization', 'submissionEvent' => function ($query) {
            $query->where('submission_status', 'approved');
        }])->where('organization_id', $id);

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
        $categories = Category::distinct()->pluck('name', 'id');

        return view('landing-sistem.organization-event', [
            'title' => 'Event ' . $organization->name,
            'events' => $events,
            'organization' => $organization,
            'categories' => $categories,
        ]);
    }

    public function organizationProfil($id)
    {
        $organization = Organization::findOrFail($id);
        return view('landing-sistem.organization-profil', [
            'title' => 'Profil ' . $organization->name,
            'organization' => $organization,
        ]);
    }
}
