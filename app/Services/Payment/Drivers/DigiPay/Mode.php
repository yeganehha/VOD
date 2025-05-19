<?php

namespace App\Services\Payment\Drivers\DigiPay;

enum Mode :string
{
    case SANDBOX = 'sandbox';
    case LIVE = 'live';

    public function getUrl()
    {
        return match ($this){
            self::SANDBOX => 'https://uat.mydigipay.info/digipay/api',
            self::LIVE => 'https://api.mydigipay.com/digipay/api',
        };
    }
}
