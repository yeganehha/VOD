<?php

return [
    'models' => [
        'wallet_transaction' => \App\Models\WalletTransaction::class,
        'reserves' => \App\Models\Reservation\Reserve::class,
    ],
    'default' => env('DEFAULT_PAYMENT_GATEWAY', 'SampleGateway'),
    'gateways' => [
        'SampleGateway' => [
            'transaction_id1' => now()->timestamp,
            'transaction_id2' => rand(1000000,9999999),
            'card_number' => rand(1000,9999).rand(1000,9999).rand(1000,9999).rand(1000,9999),
            'card_hash' => \Illuminate\Support\Facades\Crypt::encryptString(\Illuminate\Support\Str::uuid()),
        ],
        'Zarinpal' => [
            'currency' => \App\Services\Payment\Drivers\Zarinpal\CurrencyType::TOMAN,
            'merchant_id' => env('ZARINPAL_MERCHANT_ID', '00000000-0000-0000-0000-000000000000'),
        ],
        'digipay' => [
            'username' =>  env('DIGIPAY_USERNAME', ''),
            'password' =>  env('DIGIPAY_PASSWORD', ''),
            'client_id' =>  env('DIGIPAY_CLIENT_ID', ''),
            'client_secret' =>  env('DIGIPAY_SECRET', ''),
            'currency' => \App\Services\Payment\Drivers\DigiPay\CurrencyType::TOMAN,
            'mode' => env('DIGIPAY_MODE', app()->isproduction() ? \App\Services\Payment\Drivers\DigiPay\Mode::LIVE : \App\Services\Payment\Drivers\DigiPay\Mode::SANDBOX),
        ],
        'Behpardakht' => [
            'terminal_id' =>  env('BEHPARDAKHT_TERMINAL_ID', ''),
            'username' =>  env('BEHPARDAKHT_USERNAME', ''),
            'password' =>  env('BEHPARDAKHT_PASSWORD', ''),
            'currency' => \App\Services\Payment\Drivers\Behpardakht\CurrencyType::TOMAN,
        ],
    ]
];
