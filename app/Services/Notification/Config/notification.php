<?php

return [
    'channels' => [
        'sms' => [
            'driver' => 'SMSIR',
            'drivers' => [
                'KaveNegar' => [
                    'handler' => App\Services\Notification\Drivers\SMS\Kavnegar\KaveNegarDriver::class,
                    'DTO' => App\Services\Notification\Drivers\SMS\Kavnegar\KavenegarDto::class
                ],
                'SMSIR' => [
                    'handler' => App\Services\Notification\Drivers\SMS\SMS_DOT_IR\SMSIRDriver::class,
                    'DTO' => App\Services\Notification\Drivers\SMS\SMS_DOT_IR\SMSIRDto::class
                ],
            ],
        ],
        'email' => [
            'driver' => 'MailDriver',
            'DTO' => App\Services\Notification\DTO\EmailDto::class,
            'drivers' => [
                'MailDriver' => App\Services\Notification\Drivers\Email\Laravel::class,
            ],
        ],
    ],
    'models_DTO' => [
    ]
];
