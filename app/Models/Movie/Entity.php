<?php

namespace App\Models\Movie;

use App\Models\Asset\AgeRange;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'title_en',
        'slug',
        'second_title',
        'second_title_en',
        'pre_title',
        'pre_title_en',
        'type',
        'publish_status',
        'weekly_release_schedule_day',
        'weekly_release_schedule_hour',
        'about_movie',
        'about_movie_en',
        'age_range_id',
        'main_audio',
        'exclusive',
        'is_free_movie',
        'logo',
        'movie_logo',
        'pro_year',
    ];


    public function ageRange(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AgeRange::class);
    }
}
