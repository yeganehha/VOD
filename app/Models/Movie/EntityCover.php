<?php

namespace App\Models\Movie;

use App\Enums\CoverType;
use App\Enums\RatioType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property string $entity_id
 * @property string $path
 * @property Entity $entity
 * @property RatioType $ratio_type
 * @property CoverType $cover_type
 */

class EntityCover extends Model
{
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = ['id' , 'entity_id', 'ratio_type', 'cover_type' , 'path'];

    protected $casts = [
        'ratio_type' => \App\Enums\RatioType::class,
        'cover_type' => \App\Enums\CoverType::class,
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


    public function entity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }
}
