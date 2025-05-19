<?php

namespace App\Models\User;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticateAble;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 * @property string $avatar
 * @property boolean $is_block
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Admin extends AuthenticateAble implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\User\AdminFactory> */
    use  HasFactory,Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password',
        'avatar',
        'is_block',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_block' => 'boolean',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return  ! $this->is_block;
    }
}
