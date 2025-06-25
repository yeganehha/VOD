<?php

namespace App\Models\Movie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $movie_id
 * @property Movie $movie
 * @property int $crew_id
 * @property Crew $crew
 * @property int $position_id
 * @property CrewPosition $position
 */
class MovieCrew extends Model
{
    use  HasFactory;
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'movie_id',
        'crew_id',
        'position_id',
    ];

    protected $casts = [
        'crew_id' => 'int',
        'position_id' => 'int',
    ];

    public function movie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function crew(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Crew::class);
    }

    public function position(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CrewPosition::class);
    }
}
