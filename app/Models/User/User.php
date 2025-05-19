<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticateAble;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $phone
 * @property string $password
 * @property ?int $max_profiles
 * @property boolean $is_block
 * @property string $admin_description
 * @property Collection<Profile> $profiles
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends AuthenticateAble
{
    /** @use HasFactory<\Database\Factories\User\UserFactory> */
    use  HasFactory,Notifiable;

    protected $fillable = [
        'phone',
        'password',
        'max_profiles',
        'is_block',
        'admin_description',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_block' => 'boolean',
        'max_profiles' => 'int',
        'password' => 'hashed',
    ];

    public function profiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
