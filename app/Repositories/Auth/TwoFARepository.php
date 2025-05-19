<?php

namespace App\Repositories\Auth;


use App\Enums\TwoFATokenType;
use App\Models\TwoFAToken;
use Illuminate\Support\Carbon;

class TwoFARepository
{

    public function countSimilarIPRequestRecently(string $ip, int $minutes = 10): int
    {
        return TwoFAToken::query()->where('ip' , $ip)->where('created_at' , '>=' , now()->subMinutes($minutes))->count();
    }

    public function countSimilarIdentifierRequestRecently(int|string $identifier, TwoFATokenType $type, int $minutes = 10): int
    {
        return TwoFAToken::query()->where('identifier' , $identifier)->where('type' , $type)->where('created_at' , '>=' , now()->subMinutes($minutes))->count();
    }

    public function countRetry(int|string $identifier, TwoFATokenType $type, string $ip): int
    {
        /** @var TwoFAToken $result */
        $result = TwoFAToken::query()->where('ip' , $ip)->where('identifier' , $identifier)->where('type' , $type)->first('counted');
        return $result != null ? $result->counted : 0;
    }

    public function waitForRetry(int|string $identifier, TwoFATokenType $type, string $ip): ?Carbon
    {
        /** @var TwoFAToken $result */
        $result = TwoFAToken::query()->where('ip' , $ip)->where('identifier' , $identifier)->where('type' , $type)->first('updated_at');
        return $result?->updated_at;
    }

    public function getLastExistingCode(int|string $identifier, TwoFATokenType $type, ?string $ip, int $canUseRetry = 5 , int $minutes = 10): ?TwoFAToken
    {
        /** @var null|TwoFAToken $result */
        $result = TwoFAToken::query()->when($ip , function ($query) use($ip) {
            $query->where('ip' , $ip);
        })->where('identifier' , $identifier)
            ->where('type' , $type)
            ->where('counted' , '<=' , $canUseRetry )
            ->where('created_at' , '>=' , now()->subMinutes($minutes) )
            ->latest()->first();
        return $result;
    }

    public function isCodeExist(string $code , int|string $identifier, TwoFATokenType $type, ?string $ip , int $canUseRetry = 5 , int $minutes = 10 ): bool
    {
        return TwoFAToken::query()->when($ip , function ($query) use($ip) {
            $query->where('ip' , $ip);
        })->where('code' , $code)
            ->where('identifier' , $identifier)
            ->where('type' , $type)
            ->where('counted' , '<=' , $canUseRetry )
            ->where('created_at' , '>=' , now()->subMinutes($minutes) )
            ->exists();
    }

    public function deleteTrashTokensOfSpecialIdentifier(int|string $identifier, TwoFATokenType $type, ?string $ip):void
    {
        TwoFAToken::query()->when($ip , function ($query) use($ip) {
            $query->where('ip' , $ip);
        })->where('identifier' , $identifier)
            ->where('type' , $type)
            ->delete();
    }

    public function deleteTrashTokens(int $minutes = 10):void
    {
        TwoFAToken::query()
            ->where('created_at' , '<=' , now()->subMinutes($minutes))
            ->delete();
    }

    public function addNewCode(string $code, int|string $identifier, TwoFATokenType $type, ?string $ip): TwoFAToken
    {
        /** @var TwoFAToken $model */
        $model =  TwoFAToken::query()->create(compact(
            'identifier',
            'type',
            'code',
            'ip',
        ));
        return $model;
    }

    public function incrementCounter(TwoFAToken $TwoFAToken): void
    {
        $TwoFAToken->increment('counted');
    }
}
