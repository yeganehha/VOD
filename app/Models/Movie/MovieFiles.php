<?php

namespace App\Models\Movie;

use App\Enums\CoverType;
use App\Enums\RatioType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property string $movie_id
 * @property string $path
 * @property Entity $movie
 * @property RatioType $ratio_type
 * @property CoverType $cover_type
 */

class MovieFiles extends Model
{
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = ['id' , 'movie_id', 'ratio_type' , 'path'];

    protected $casts = [
        'ratio_type' => \App\Enums\RatioType::class,
    ];



    public function getPathLinkAttribute()
    {
        return asset('storage/' . str_replace('\\','/' , $this->attributes['path']));
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            /** @var self $model */
            do {
                $model->id = Str::uuid();
            } while ( self::query()->where('id', $model->id)->exists() );
        });
    }


    public function movie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
