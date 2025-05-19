<?php

namespace App\Services\Auth;

use App\Enums\TwoFATokenType;
use App\Models\TwoFAToken;
use App\Repositories\Auth\TwoFARepository;
use App\Services\Notification\Enums\NotificationPriority;
use App\Services\Notification\NotificationManager;
use BadMethodCallException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\LostConnectionException;
use Illuminate\Support\Str;
use Throwable;

class TwoFAService
{

    public string $ip;

    public function __construct(public TwoFARepository $twoFARepository)
    {
        $this->ip = request()->ip();
    }


    /**
     * Request New 2FA Token.
     * @param TwoFATokenType $type
     * @param int|string $identifier
     * @return bool
     * @throws Throwable
     */
    public function request2FA(TwoFATokenType $type, int|string $identifier): bool
    {
        $this->canGenerate2FACode( $type , $identifier);
        $TwoFAToken = $this->generateNewCode($type , $identifier);
        return $this->notify($type , $identifier , $TwoFAToken);
    }

    /**
     * check code is valid?
     * @param TwoFATokenType $type
     * @param int|string $identifier
     * @param string $code
     * @return bool
     */
    public function isValid2FA(TwoFATokenType $type, int|string $identifier, string $code): bool
    {
        $isValid = $this->twoFARepository->isCodeExist( $code , $identifier , $type , $this->ip , config('user.2FA.'.Str::camel($type->value).'.retry' , 5)  , config('user.2FA.'.Str::camel($type->value).'.twoFA_toke_for_same_identifier.in_last_minutes' , 10) );
        $isValid =  (app()->environment() !== 'production' and $code == '1234') ? true : $isValid;
        if ( $isValid )
            $this->clearTrashToken($type, $identifier);
        return $isValid ;
    }

    /**
     * @throws Throwable
     */
    public function canGenerate2FACode(TwoFATokenType $type, int|string $identifier): true
    {
        $countSimilarIPRequestRecently = $this->twoFARepository->countSimilarIPRequestRecently( $this->ip , config('user.2FA.'.Str::camel($type->value).'.twoFA_toke_for_same_ip.in_last_minutes' , 10) );
        throw_if($countSimilarIPRequestRecently > config('user.2FA.'.Str::camel($type->value).'.twoFA_toke_for_same_ip.time_to_allow' , 5)  , new AuthenticationException('تعداد درخواست های شما در چند دقیقه گذشته بیش از حد مجاز بوده است، لطفا دقایقی دیگر امتحان نمایید.') );


        $countSimilarIdentifierRequestRecently = $this->twoFARepository->countSimilarIdentifierRequestRecently( $identifier , $type , config('user.2FA.'.Str::camel($type->value).'.twoFA_toke_for_same_identifier.in_last_minutes' , 10) );
        throw_if($countSimilarIdentifierRequestRecently > config('user.2FA.'.Str::camel($type->value).'.twoFA_toke_for_same_identifier.time_to_allow' , 5)  , new AuthenticationException( 'به دلیل درخواست از طریق چندین دستگاه مختلف، تا لحظاتی عملیات مورد نظر مسدود می باشد. لطفا دقایقی دیگر امتحان نمایید.') );

        $countRetry = $this->twoFARepository->countRetry( $identifier , $type , $this->ip);
        throw_if($countRetry > config('user.2FA.'.Str::camel($type->value).'.retry' , 5)  , new AuthenticationException('تعداد درخواست های شمابیش از حد مجاز بوده است، لطفا دقایقی دیگر امتحان نمایید.') );

        $waitForRetry = $this->twoFARepository->waitForRetry( $identifier , $type , $this->ip);
        throw_if($waitForRetry and $waitForRetry > now()->subMinutes(config('user.2FA.'.Str::camel($type->value).'.waitForRetry')) , new AuthenticationException( 'به تازگی کد جدیدی برای شما ساخته شده است. لطفا منتظر باشید تا کد جدید برسد.'));

        return true ;
    }

    /**
     * @throws Throwable
     */
    public function generateNewCode(TwoFATokenType $type, int|string $identifier): TwoFAToken
    {
        $TwoFAToken = $this->getExistingCode($type, $identifier);
        if ( $TwoFAToken != null ){
            $this->twoFARepository->incrementCounter($TwoFAToken);
            return $TwoFAToken;
        }
        return $this->generateRandomCode($type, $identifier);
    }

    public function notify(TwoFATokenType $type, int|string $identifier, string|TwoFAToken $twoFAToken) :bool
    {
        $handlerMethod = '___'.Str::camel($type->value);
        if ( method_exists($this , $handlerMethod) )
            return $this->{$handlerMethod}($identifier , $twoFAToken);
        throw new BadMethodCallException(sprintf("Can not notify %s! Please add `%s` method inside %s. simple code: \n%s" , $type->name , $handlerMethod , self::class , 'private function '.$handlerMethod.'(int|string $identifier, string $code):bool { return true;}') ) ;
    }
    public function clearTrashToken(TwoFATokenType $type, int|string $identifier):void
    {
        $this->twoFARepository->deleteTrashTokensOfSpecialIdentifier($identifier , $type, $this->ip);
    }
    private function getExistingCode(TwoFATokenType $type, int|string $identifier): ?TwoFAToken
    {
        return $this->twoFARepository->getLastExistingCode( $identifier , $type , $this->ip);
    }

    /**
     * @throws Throwable
     */
    private function generateRandomCode(TwoFATokenType $type, int|string $identifier): TwoFAToken
    {
        $retryInsert = 0 ;
        do {
            do {
                $code = strtoupper(fake()->bothify(config('user.2FA.'.Str::camel($type->value).'.code_format')));
            } while (  $this->twoFARepository->isCodeExist( $code , $identifier , $type , $this->ip , config('user.2FA.'.Str::camel($type->value).'.retry' , 5)  , config('user.2FA.'.Str::camel($type->value).'.twoFA_toke_for_same_identifier.in_last_minutes' , 10)) );
            throw_if($retryInsert > 5 , new LostConnectionException() );
            $retryInsert++;
        } while ( ! $twoFAToken = $this->twoFARepository->addNewCode( $code , $identifier , $type , $this->ip )  );
        return $twoFAToken;
    }

    private function ___phone(int|string $identifier, string|TwoFAToken $twoFAToken):bool
    {
        try {
            NotificationManager::queueSend($twoFAToken , $identifier,NotificationPriority::High);
            return true;
        } catch (\Exception $exception){
            return false;
        }
    }

}
