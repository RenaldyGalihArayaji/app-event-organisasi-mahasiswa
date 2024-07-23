<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    public function index()
    {
        $events = Event::with(['category', 'organization'])->get();
        return view('master.calender.index', ['title' => 'Calender'], compact('events'));
    }
}
