<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(User::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'News',
        'Showbizz/Entertainment',
        'Royals',
        'Food/Recipes',
        'Lifehacks',
        'Fashion',
        'Beauty',
        'Health',
        'Family',
        'House and garden',
        'Cleaning',
        'Lifestyle',
        'Cars',
        'Crime',
    ];
}
