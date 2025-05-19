<?php

namespace App\Services\Notification\Drivers\SMS\Kavnegar;

use App\Models\User;
use App\Services\Notification\Contracts\NotificationDriverInterface;
use App\Services\Notification\Contracts\NotificationDTOInterface;
use Illuminate\Support\Facades\Log;

class KaveNegarDriver implements NotificationDriverInterface
{

    public function send(KavenegarDto|NotificationDTOInterface $data, User|string|int $recipient): void
    {
        // کد مربوط به ارسال پیام از طریق کاوه‌نگار
        // می‌تواند یک درخواست HTTP به API کاوه‌نگار باشد
        // برای مثال:
        // Http::post('https://api.kavenegar.com/v1/your-api-key/sms/send.json', [
        //     'receptor' => $recipient,
        //     'message' => $message,
        // ]);
        Log::info("Message sent via KaveNegar to ".(is_a($recipient,User::class,true) ? $recipient->phone : $recipient)." : $data->token");
    }
}
