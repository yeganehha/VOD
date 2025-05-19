<?php

namespace App\Models\Movie;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property integer $sort
 */
class CrewPosition extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title',
        'slug',
        'sort',
    ];

    protected $casts = [
        'sort' => 'int',
    ];
}
