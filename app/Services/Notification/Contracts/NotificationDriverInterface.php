<?php

namespace App\Services\Notification\Contracts;

use App\Models\User;

interface NotificationDriverInterface
{
    public function send(NotificationDTOInterface $data,User|int|string $recipient) : void;
}
