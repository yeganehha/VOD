<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title
 * @property int $from_age
 * @property int $to_age
 * @property boolean $is_kid
 * @property int $sort
 */
class AgeRange extends Model
{
    use  SoftDeletes;
    protected $fillable = [
        'title' ,
        'from_age' ,
        'to_age' ,
        'is_kid',
        'sort'
    ];

    protected $casts = [
        'is_kid' => 'boolean',
        'sort' => 'int',
        'from_age' => 'int',
        'to_age' => 'int',
    ];
}
