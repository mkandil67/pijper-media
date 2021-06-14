<?php

namespace App\Http\Controllers;


// This controller shows an authenticated user the posts from the categories he chose from different platforms

class CalendarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        return view('calendar');
    }
}
