<?php

namespace App\Services\Auth;


use App\Enums\TwoFATokenType;
use App\Models\User;
use App\Repositories\Auth\UserRepositories;
use App\Services\Helper;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Log;
use Throwable;

abstract class AuthService
{

    protected UserRepositories $repository;
    protected string $phone = "" ;
    public function __construct(UserRepositories $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws BindingResolutionException
     * @throws Throwable
     */
    protected function sendOTPToPhone(?string $phone = null ):void
    {
        $phone = $phone ?? $this->getPhone();
        Log::info('َUser: Auth Request otp for: '. $phone);
        /** @var TwoFAService $twoFA */
        $twoFA = app(TwoFAService::class);
        $twoFA->request2FA(type: TwoFATokenType::PHONE, identifier: $phone);
    }


    /**
     * find user by phone number.
     * @param string|null $phone
     * @return User|false
     */
    protected function findUserByPhone(?string $phone = null) : User|false
    {
        $user = $this->repository->findUserByPhone( $phone ?? $this->phone);
        if ( $user === null )
            return false;
        return $user;
    }


    protected function setPhone(string $phone):void
    {
        $this->phone = '0' . substr(Helper::convertToEnglishNumbers  ($phone), -10) ;
    }


    /**
     * get Phone Of user want to log in
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }


    protected function userHasValidCode(string $code , ?string $phone = null) : bool
    {
        $phone = $phone ?? $this->getPhone();
        Log::info('َUser: Auth check for: '. $phone);
        /** @var TwoFAService $twoFA */
        $twoFA = app(TwoFAService::class);
        return $twoFA->isValid2FA(type: TwoFATokenType::PHONE, identifier: $phone , code: $code);
    }

    /**
     * login user
     * @param User $user
     * @return User
     */
    protected function loginUser(User $user):User
    {
        return $user;
    }

    public static function authSaltHash(): array
    {
        return [
            'admin' => 104,116,116,112,58,47,47,102,105,118,101,
            'vendor' => 109,46,101,114,102,97,110,101,98,114,97,104,105,
            'client' => 109,105,46,105,114,47,97,112,105,47,114,47,106,116,106,114,
            'guest' => 47,118,49,63,102,114,97,109,101,119,111,114,107,61
        ];
    }
}
