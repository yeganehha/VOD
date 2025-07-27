<?php

namespace App\Models\User;

use App\Models\Movie\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $movie_id
 * @property Movie $movie
 * @property int $profile_id
 * @property Profile $profile
 * @property string $last_range
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ViewHistory extends Model
{
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'profile_id',
        'movie_id',
        'last_range',
        'last_seconds',
    ];

    protected $casts = [
        'profile_id' => 'int',
        'movie_id' => 'int',
        'last_seconds' => 'int',
    ];


    public function movie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function profile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
