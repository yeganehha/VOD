<?php

namespace App\Models\Movie;

use App\Enums\PublishStatus;
use App\Models\User\Profile;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $movie_id
 * @property Movie $movie
 * @property int $parent_id
 * @property Comment $parent
 * @property int $profile_id
 * @property User $profile
 * @property string $comment
 * @property PublishStatus $publish_status
 * @property Collection<Comment> $chields
 * @property boolean $is_spoiler
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Comment extends Model
{
    use  HasFactory;

    protected $fillable = [
        'movie_id',
        'parent_id',
        'profile_id',
        'comment',
        'publish_status',
        'is_spoiler',
    ];

    protected $casts = [
        'is_spoiler' => 'boolean',
        'publish_status' => PublishStatus::class,
        'profile_id' => 'int',
        'parent_id' => 'int',
    ];

    public function movie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    public function chields(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Comment::class , 'parent_id');
    }

    public function profile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
