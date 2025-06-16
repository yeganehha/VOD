<?php

namespace App\Models\Movie;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;


/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property boolean $for_kids
 * @property boolean $hide_from_kids
 * @property integer $sort
 * @property Collection<Entity> $entities
 */
class Genre extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title',
        'slug',
        'for_kids',
        'hide_from_kids',
        'sort',
    ];

    protected $casts = [
        'for_kids' => 'boolean',
        'hide_from_kids' => 'boolean',
        'sort' => 'int',
    ];

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class , 'entity_genres');
    }
}
