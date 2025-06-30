<?php

namespace App\Models\User;

use App\Models\Asset\AgeRange;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property string $name
 * @property string $avatar
 * @property int $age_range_id
 * @property AgeRange $ageRange
 * @property boolean $main_user
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id' ,
        'name' ,
        'avatar' ,
        'age_range_id' ,
        'main_user' ,
    ];

    protected $casts = [
        'user_id' => 'int',
        'age_range_id' => 'int',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ageRange(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AgeRange::class);
    }

    public function avatarLink(): string
    {
        return ( ! empty($this->avatar)) ? asset('storage/'. $this->avatar) : asset('assets/images/avatar.png');
    }
}
