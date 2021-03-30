<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Posts blueprint

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    public $primaryKey = 'id';
    protected $fillable = [
        'writer_id',
    ];
}
