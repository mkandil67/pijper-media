<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Post;
use App\Models\User;
use App\Models\Accounts;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;

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
        $calendardates = DB::table('calendar')->select('title','start','allDay','className')->get();
        foreach ($calendardates as $date) {
            if ($date->allDay) {
                $date->allDay = 'true';
            }
        }
        $biep = json_encode($calendardates);
        dd($biep);
        return view('calendar', ['calendardates' => $calendardates]);
    }
}
