<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Post;
use App\Models\Accounts;

// This controller shows an authenticated user the posts from the categories he chose from different platforms

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
        $accounts = Accounts::all();
        $posts = Post::all();
        return view('home', ['user' => $user, 'posts' => $posts, 'accounts' => $accounts], ['categories' => $categories]);
    }
}
