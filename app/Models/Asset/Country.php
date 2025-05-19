<?php

namespace App\Models\Asset;

use App\Services\Helper;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $flag
 * @property string $icon
 * @property string $medium_flag
 * @property string $normal_flag
 * @property string $large_flag
 */
class Country extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
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
}
