<?php

namespace App\Http\Controllers;

use App\Models\Categories;

use App\Models\Post;

// This controller will show activities of different users to the authenticated user

class ActivityController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        $user = auth()->user();
        $categories = Categories::where('user_id',$user->id)->get()->first();
        $posts = Post::all();
        return view('activity', ['user' => $user, 'posts' => $posts], ['categories' => $categories]);
    }
}
