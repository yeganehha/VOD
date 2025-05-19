<?php

namespace App\Services\Notification\Enums;
enum NotificationPriority: string
{
    case RightNow = 'RightNow';
    case High = 'high';
    case Medium = 'medium';
    case Default = 'default';
    case Low = 'low';
}
