<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Post;
use App\Models\User;

// This controller will show activities of different users to the authenticated user

class ActivityController extends Controller {
    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        $user = auth()->user();
        $categories = Categories::where('user_id',$user->id)->get()->first();
        $posts = Post::all();
        return view('activity', ['user' => $user, 'posts' => $posts], ['categories' => $categories]);
    }
}
