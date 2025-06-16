<?php

namespace App\Models\Movie;

use App\Enums\Audio;
use App\Enums\EntityType;
use App\Enums\PublishStatus;
use App\Enums\WeekDay;
use App\Models\Asset\AgeRange;
use App\Models\Asset\Country;
use App\Services\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property string $id
 * @property string $title
 * @property string $title_en
 * @property string $slug
 * @property string $second_title
 * @property string $second_title_en
 * @property string $pre_title
 * @property string $pre_title_en
 * @property EntityType $type
 * @property PublishStatus $publish_status
 * @property WeekDay $weekly_release_schedule_day
 * @property Carbon $weekly_release_schedule_hour
 * @property string $about_movie
 * @property string $about_movie_en
 * @property int $age_range_id
 * @property AgeRange $age_range
 * @property Audio $main_audio
 * @property boolean $exclusive
 * @property boolean $is_free_movie
 * @property string $logo
 * @property string $movie_logo
 * @property string $pro_year
 * @property Collection<Country> $countries
 * @property Collection<Genre> $genres
 * @property Collection<EntityCover> $covers
 * @property Collection<Movie> $movies
 * @property Carbon $deleted_at
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Entity extends Model
{
    use SoftDeletes,HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
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


    protected $casts = [
        'type' => EntityType::class,
        'publish_status' => PublishStatus::class,
        'pro_year' => 'int',
        'is_free_movie' => 'boolean',
        'exclusive' => 'boolean',
        'main_audio' => Audio::class,
        'weekly_release_schedule_day' => WeekDay::class,
        'age_range_id' =>  'int',
        'weekly_release_schedule_hour' =>  'datetime:H:i',
    ];



    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            /** @var self $model */
            do {
                $model->id = Str::random(8);
            } while ( self::query()->where('id', $model->id)->exists() );
        });
    }


    public function ageRange(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AgeRange::class);
    }

    public function countries(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'entity_country');
    }

    public function covers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EntityCover::class);
    }

    public function genres(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'entity_genres');
    }

    public function movies(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Movie::class);
    }

}
