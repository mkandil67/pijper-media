<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Categories;
use App\Models\Post;
use Illuminate\Http\Request;

class ViralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        $user = auth()->user();
        $posts = Post::all();
        $accounts = Accounts::all();
        return view('viral', ['user' => $user, 'accounts' => $accounts, 'posts' => $posts]);
    }
}
