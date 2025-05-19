<?php

namespace App\Services\Notification\Contracts;

use DragonCode\Support\Helpers\Ables\Arrayable;
use Illuminate\Database\Eloquent\Model;

interface ModelNotificationDTOInterface
{
    public function prepareData(NotificationCanMap $record): array|Arrayable|NotificationDTOInterface;
}
