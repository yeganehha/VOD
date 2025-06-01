<?php

namespace App\Models\User;

use App\Enums\UserType;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticateAble;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $name
 * @property string $password
 * @property string $avatar
 * @property boolean $is_block
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Admin extends AuthenticateAble implements FilamentUser
{
    use HasRoles;
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

    protected $appends = [
        'name'
    ];

    public function getNameAttribute(): string
    {
        return $this->first_name ? $this->first_name . ' ' . $this->last_name : $this->username;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        try {
            return ($this->hasRole(Utils::getSuperAdminName()) || $this->roles()->count() > 0) and ! $this->is_block;
        } catch (\Exception $e) {}
        return false;
    }
}
