<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function create()
    {
        return view('categories');
    }

    public function store(Request $request)
    {
        $selectedCategories = $request->categories;
        // initialize insertarray with the standard values
        $insertArray = array(
            'user_id' => $request->user()->id,
            'News' => 0,
            'Showbizz/Entertainment' => 0,
            'Royals' => 0,
            'Food/Recipes' => 0,
            'Lifehacks' => 0,
            'Fashion' => 0,
            'Beauty' => 0,
            'Health' => 0,
            'Family' => 0,
            'House and garden' => 0,
            'Cleaning' => 0,
            'Lifestyle' => 0,
            'Cars' => 0,
            'Crime' => 0,
        );
        // give insertarray with the selected values
        foreach ($selectedCategories as $cat) {
            $insertArray[$cat] = 1;
        }
        // if the person has not filled in a preference before, store it in the table, else update the existing row
        if (Categories::query()->where('user_id', $request->user()->id)->count() == 0) {
            Categories::create($insertArray);
        } else {
            Categories::query()->where('user_id', $request->user()->id)->update($insertArray);
        }
        return redirect('/home');
    }
}
