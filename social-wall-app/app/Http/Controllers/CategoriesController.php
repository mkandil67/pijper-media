<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show($user)
    {
        $user = User::find($user);
        return view('categories', [
            'user' => $user,
        ]);
    }
}
