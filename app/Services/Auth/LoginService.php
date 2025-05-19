<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class LoginService extends AuthService
{
    /**
     * When user want to log in, this method check and detect scenario of login
     * @param string $phone
     * @return true
     * @throws \Throwable
     */
    public function startLoginProcess(string $phone): true
    {
        $this->setPhone($phone);
        $user = $this->findUserByPhone();
        if ($user === false) {
            throw new ResourceNotFoundException();
        }
        $this->sendOTPToPhone();
        return true;
    }

    /**
     * get 2fa and login user
     * @param string $phone
     * @param string $code
     * @param string|bool $device
     * @param string|null $agent
     * @param string|null $device_token
     * @param string|null $device_push_notification
     * @return User
     * @throws AuthenticationException
     */
    public function login(string $phone, string $code, bool|string $device = "Unknown", ?string $agent = null, ?string $device_token = null, ?string $device_push_notification = null): User
    {
        $this->setPhone($phone);
        /** @var ?User $user */
        $user = $this->findUserByPhone();
        if ($user === false) {
            throw new BadRequestException('کاربری یافت نشد!');
        }
        if ($this->userHasValidCode($code) and $this->authSaltHash()) {
            return $this->loginUser($user);
        }
        throw new AuthenticationException('کد اعتبارسنجی صحیح نمی باشد!');
    }


    public function isUserExists(string $phone): bool
    {
        $this->setPhone($phone);
        /** @var ?User $user */
        $user = $this->findUserByPhone();
        return $user !== false;
    }
}
