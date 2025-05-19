<?php

namespace App\Services\Notification\Provider;

use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{

    public function boot():void
    {
        $this->mergeConfigFrom(app_path('Services/Notification/config/notification.php') , 'notification');
    }
}
