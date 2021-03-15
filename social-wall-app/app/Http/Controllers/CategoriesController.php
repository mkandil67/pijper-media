<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function store()
    {
        return view('categories');
    }
}
