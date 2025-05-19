<?php

namespace App\Services\Notification\Contracts;

interface NotificationDTOInterface
{
    public function isValid(): bool;
    public function toArray(): array;
}
