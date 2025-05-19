<?php

namespace App\Services\Auth;

use App\DTO\OtherSMS;
use App\Models\User;
use App\Services\Helper;
use App\Services\Notification\Enums\NotificationPriority;
use App\Services\Notification\NotificationManager;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;

class RegisterService extends AuthService
{

    /**
     * When user want to log in, this method check and detect scenario of login
     * @param string $phone
     * @return true
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function startRegisterProcess(string $phone) : true
    {
        $this->setPhone($phone);
        $user = $this->findUserByPhone();
        if ( $user !== false ) {
            Throw new \Exception('شماره موبایل تکراری است!');
        }
        $this->sendOTPToPhone();
        return true;
    }


    /**
     * get 2fa and login user
     * @param string $phone
     * @param string $code
     * @param string|null $first_name
     * @param string|null $last_name
     * @param string|null $online_chat_token
     * @param string|null $referral_code
     * @return User
     * @throws AuthenticationException
     * @throws Throwable
     */
    public function register(string $phone, string $code, ?string $first_name = null, ?string $last_name = null, ?string $online_chat_token = null, ?string $referral_code = null):User
    {
        $this->setPhone($phone);
        /** @var ?User $user */
        $user = $this->findUserByPhone();
        if ( $user !== false ) {
            Throw new BadRequestException('شماره موبایل تکراری است!');
        }
        DB::beginTransaction();
        if ( $this->userHasValidCode($code) ) {
            $referral_user = null;
            if ( $referral_code ){
                /** @var User $referral_user */
                $referral_user = User::query()->where('referral_code', $referral_code)->first();
            }
            $user = $this->repository->registerUser(
                phone:$phone,
                first_name:$first_name,
                last_name:$last_name,
                online_chat_token:$online_chat_token,
                referral_user:$referral_user
            );
            try {
                NotificationManager::queueSend((new OtherSMS($user, 'userRegister')), $user, NotificationPriority::Medium);
            } catch (\Exception $e) {
                Log::Error('Error in sending notification! userRegister', ['message' => $e->getMessage()]);
            }
            $user = $this->loginUser($user);
            DB::commit();
//            Helper::cacheHashedSalt();
            return $user;
        }
        DB::rollBack();
        Throw new AuthenticationException('کد اعتبارسنجی صحیح نمی باشد!');
    }

    public function updateProfileIfEmpty(User $user,?string $firstName = null,?string $lastName = null,?Carbon $birthday = null,?string $avatarLink = null): void
    {
        $user->first_name = $user->first_name ?? $firstName;
        $user->last_name = $user->last_name ?? $lastName;
        $user->birth_date = $user->birth_date ?? $birthday;
        if ( $avatarLink !== null and $user->avatar === null){
            Storage::makeDirectory('public/avatar/'.now()->format('Y/m/d'));
            $newLink = 'avatar/'.now()->format('Y/m/d').'/'.Str::uuid().'.'. pathinfo($avatarLink, PATHINFO_EXTENSION);
            copy($avatarLink, storage_path('app/public/'.$newLink));
            $user->avatar = $newLink;
        }
        $user->save();
    }
}
