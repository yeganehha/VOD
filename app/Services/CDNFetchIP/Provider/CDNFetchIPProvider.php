<?php

namespace App\Services\CDNFetchIP\Provider;

use App\Services\CDNFetchIP\Commands;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class CDNFetchIPProvider extends ServiceProvider
{

    public function boot(Router $router):void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\CDNFetchIPCommand::class,
                Commands\CDNListIpCommand::class,
                Commands\CDNMakeCommand::class,
            ]);
        }
    }
}
