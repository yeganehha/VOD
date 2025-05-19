<?php

namespace App\Repositories\Auth;

use App\Enums\UserType;
use App\Models\User;
use App\Services\Helper;
use Throwable;

class UserRepositories
{

    /**
     * Find User By phone number
     * @param string $phone
     * @return User|null
     */
    public function findUserByPhone(string $phone): ?User
    {
        /** @var ?User $user */
        $user = User::query()->where('phone', $phone)->first();
        return $user;
    }

    /**
     * Find User By Id
     * @param int $id
     * @return User|null
     */
    public function findUserById(int $id): ?User
    {
        /** @var ?User $user */
        $user = User::query()->find($id);
        return $user;
    }

    /**
     * Find User By phone number
     * @param string $code
     * @return User|null
     */
    public function findUserByReferralCode(string $code): ?User
    {
        /** @var ?User $user */
        $user = User::query()->where('referral_code', $code)->first();
        return $user;
    }

    /**
     * Make new user.
     * @param string $phone
     * @param string|null $first_name
     * @param string|null $last_name
     * @param string|null $national_code
     * @param string|null $birthday
     * @param string|null $online_chat_token
     * @return User
     * @throws Throwable
     */
    public function registerUser(string $phone, ?string $first_name = null, ?string $last_name = null, ?string $birthday = null, ?string $online_chat_token = null, ?User $referral_user = null): User
    {
        do {
            $code = strtoupper(fake()->bothify(config('user.Referral.code_format' , '****')));
        } while ( $this->findUserByReferralCode($code) );
        $user = new User();
        $user->phone = '0' . substr(Helper::convertToEnglishNumbers($phone), -10) ;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->birth_date = $birthday;
        $user->referral_code = $code;
        $user->affiliated_by_id = $referral_user?->id;
        $user->type = UserType::Host->value;
        $user->is_block = false;
        $user->online_chat_token = $online_chat_token;
        $user->saveOrFail();
        return $user;
    }
}
