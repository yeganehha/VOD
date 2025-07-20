<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthenticateAble;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

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


    protected static function boot()
    {
        parent::boot();
        static::created(function (Model $model) {
            /** @var self $model */
            $model->profiles()->create([
                'name' => 'خودم',
                'age_range_id' => 6,
                'main_user' => true,
            ]);
        });
    }

    public function profiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Profile::class);
    }

    public function currentProfile() : Profile
    {
        return Request::cookie('currentProfile') == null ?
            $this->profiles()->where('main_user' , 1)->firstOrFail() :
            $this->profiles()->findOrFail(Request::cookie('currentProfile')) ;
    }
}
