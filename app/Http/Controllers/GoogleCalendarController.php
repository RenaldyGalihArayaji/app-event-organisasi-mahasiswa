<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;

class GoogleCalendarController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new \Google_Client();
        $client->setClientId(config('google-calendar.client_id'));
        $client->setClientSecret(config('google-calendar.client_secret'));
        $client->setRedirectUri(config('google-calendar.redirect_uri'));
        $client->addScope(\Google_Service_Calendar::CALENDAR);

        return redirect()->away($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new \Google_Client();
        $client->setClientId(config('google-calendar.client_id'));
        $client->setClientSecret(config('google-calendar.client_secret'));
        $client->setRedirectUri(config('google-calendar.redirect_uri'));
        $client->authenticate($request->code);

        session(['google_calendar_access_token' => $client->getAccessToken()]);

        return redirect()->route('your-desired-route');
    }
}
