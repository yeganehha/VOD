<?php

namespace App\Models\Asset;

use App\Models\Movie\Entity;
use App\Services\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string $code
 * @property string $flag
 * @property string $icon
 * @property string $medium_flag
 * @property string $normal_flag
 * @property string $large_flag
 * @property Collection<Entity> $entities
 */
class Country extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title',
        'title_en',
        'code',
        'flag',
    ];

    protected $appends = [
        'icon',
        'medium_flag',
        'normal_flag',
        'large_flag',
    ];

    public function getIconAttribute():string
    {
        /** TODO: Add Logo of none image */
        return $this?->flag ? asset('storage/countries/icon/'.$this->flag) : (Helper::setting('logo') ? asset('storage/'.Helper::setting('logo')): asset('assets/images/residence.png'));
    }

    public function getMediumFlagAttribute():string
    {
        /** TODO: Add Logo of none image */
        return $this?->flag ? asset('storage/countries/medium/'.$this->flag) : (Helper::setting('logo') ? asset('storage/'.Helper::setting('logo')): asset('assets/images/residence.png'));
    }

    public function getNormalFlagAttribute():string
    {
        /** TODO: Add Logo of none image */
        return $this?->flag ? asset('storage/countries/normal/'.$this->flag) : (Helper::setting('logo') ? asset('storage/'.Helper::setting('logo')): asset('assets/images/residence.png'));
    }

    public function getLargeFlagAttribute():string
    {
        /** TODO: Add Logo of none image */
        return $this?->flag ? asset('storage/countries/large/'.$this->flag) : (Helper::setting('logo') ? asset('storage/'.Helper::setting('logo')): asset('assets/images/residence.png'));
    }

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class , 'entity_country');
    }
}
