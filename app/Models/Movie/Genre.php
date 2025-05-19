<?php

namespace App\Models\Movie;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'for_kids',
        'hide_from_kids'
    ];

    protected $casts = [
        'for_kids' => 'boolean',
        'hide_from_kids' => 'boolean'
    ];
}
