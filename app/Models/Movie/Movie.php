<?php

namespace App\Models\Movie;

use App\Enums\Audio;
use App\Models\Asset\AgeRange;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property string $id
 * @property string $entity_id
 * @property string $title
 * @property string $title_en
 * @property Entity $entity
 * @property bool $is_high_definition
 * @property int|null $age_range_id
 * @property AgeRange|null $ageRange
 * @property Audio|null $main_audio
 * @property string|null $description
 * @property string|null $description_en
 * @property bool $dubbed
 * @property int|null $duration
 * @property bool $exclusive
 * @property bool $is_multi_audio
 * @property bool $has_subtitle
 * @property float $imdb_rate
 * @property Carbon|null $publish_date
 * @property int|null $pro_year
 * @property int $season
 * @property Collection<MovieCover> $covers
 * @property Collection<MovieCrew> $crews
 * @property Collection<Comment> $comments
 * @property int $episode
 * @property Carbon|null $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */


class Movie extends Model
{
    use SoftDeletes,HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'title' , 'title_en' ,'entity_id', 'is_high_definition', 'age_range_id', 'main_audio',
        'description', 'description_en', 'dubbed', 'duration', 'exclusive',
        'is_multi_audio', 'has_subtitle', 'imdb_rate', 'publish_date', 'pro_year',
        'season' , 'episode'
    ];
    // TODO: duration should be auto compile

    protected $casts = [
        'is_high_definition' => 'boolean',
        'age_range_id' => 'int',
        'main_audio' => \App\Enums\Audio::class,
        'dubbed' => 'boolean',
        'duration' => 'int',
        'exclusive' => 'boolean',
        'is_multi_audio' => 'boolean',
        'has_subtitle' => 'boolean',
        'imdb_rate' => 'float',
        'publish_date' => 'date',
        'pro_year' => 'int',
        'season' => 'int',
        'episode' => 'int',
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


    public function durationTitle($format = '%d ساعت %d دقیقه'): string
    {
        if ($format == '%d ساعت %d دقیقه' and intdiv($this->attributes['duration'], 60) == 0)
            return  $this->attributes['duration'] .' دقیقه' ;
        if ($format == '%d ساعت %d دقیقه' and $this->attributes['duration'] %  60 == 0)
            return intdiv($this->attributes['duration'], 60) .' ساعت' ;
        return  sprintf($format , intdiv($this->attributes['duration'], 60) , ($this->attributes['duration'] % 60)) ;
    }

    public function getLink($short=false): string
    {
        if ( $short )
            return route('movie.short' , $this->id);
        if ( $this->entity->type == \App\Enums\EntityType::Movie )
            return response()->redirectTo(route("movie.show" , $this->entity->slug));
        if ( $this->entity->type == \App\Enums\EntityType::MultiSeasonSeries )
            return response()->redirectTo(route("movie.series" , [$this->entity->slug, $this->season, $this->episode]));
        return response()->redirectTo(route("movie.episode" , [$this->entity->slug,$this->episode]));
    }

    public function getImage($width, $height): ?string
    {
        $path = optional(
            $this->covers
                ->sortBy(fn($img) => abs($img->ratio_type->division() - ((float)$width / (float) $height)))
                ->filter(fn($img) => $img->path and file_exists(storage_path('app/public/' . $img->path)))
        )->first()?->path;
        return $path ? asset('storage/'.$path) : $this->entity->getImage($width, $height);
    }



    public function entity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function ageRange(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AgeRange::class);
    }


    public function covers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MovieCover::class);
    }


    public function crew(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MovieCrew::class);
    }


    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

}
