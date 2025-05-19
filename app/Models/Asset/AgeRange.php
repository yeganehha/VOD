<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgeRange extends Model
{
    use  SoftDeletes;
    protected $fillable = [
        'title' ,
        'is_kid',
        'sort'
    ];

    protected $casts = [
        'is_kid' => 'boolean',
        'sort' => 'int',
    ];
}
