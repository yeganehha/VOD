<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    \App\Services\CDNFetchIP\Provider\CDNFetchIPProvider::class,
    \App\Services\Notification\Provider\NotificationServiceProvider::class,
    \App\Services\Payment\Provider\PaymentServiceProvider::class,
];
