<?php

namespace App\Models\Movie;

use App\Enums\Gender;
use App\Models\Asset\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property string $slug
 * @property string $biography
 * @property string $biography_en
 * @property Carbon $birthday
 * @property Carbon $death_at
 * @property int $birth_location_id
 * @property Country $birth_location
 * @property Gender $gender
 * @property string $avatar
 * @property int $main_position_id
 * @property CrewPosition $main_position
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Crew extends Model
{
    use  HasFactory;
    protected $fillable = [
        'name' ,
        'name_en' ,
        'slug' ,
        'biography' ,
        'biography_en' ,
        'birthday' ,
        'death_at' ,
        'birth_location_id' ,
        'gender' ,
        'avatar' ,
        'main_position_id' ,
    ];

    protected $casts = [
        'main_position_id' => 'int',
        'birth_location_id' => 'int',
        'gender' => Gender::class,
        'death_at' => 'date',
        'birthday' => 'date',
    ];

    public function birth_location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function main_position(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CrewPosition::class);
    }
}
