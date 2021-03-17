<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\User;

class HomeController extends Controller
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
        $user = auth()->user();
        $categories = Categories::where('user_id',$user->id)->get()->first();

        return view('home', ['user' => $user], ['categories' => $categories]);
    }
}
