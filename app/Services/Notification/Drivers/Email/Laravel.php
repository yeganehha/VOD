<?php

namespace App\Services\Notification\Drivers\Email;

use App\Models\User;
use App\Services\Notification\Contracts\NotificationDriverInterface;
use App\Services\Notification\Contracts\NotificationDTOInterface;
use App\Services\Notification\DTO\EmailDto;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Laravel implements NotificationDriverInterface
{
    public function send(EmailDto|NotificationDTOInterface $data,User|string|int $recipient): void
    {
//        Mail::to($recipient->email)->send(new YourMailableClass($data));
        Log::info("Message sent via email to ".(is_a($recipient,User::class,true) ? $recipient->email : $recipient)." : $data->subject");
    }
}
