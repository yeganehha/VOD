<?php

namespace App\Providers;

use App\Policies\RolePolicy;
use Filament\Forms\Components\Field;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Gate::policy(Role::class, RolePolicy::class);
        $mainPath = database_path('migrations');
        $directories = glob($mainPath . '/*' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
        $this->loadMigrationsFrom($paths);


        FilamentAsset::register(
            assets: [
                Css::make('filament-slim-scrollbar', resource_path('css/slim-scrollbar.css')),
            ]
        );
        Activity::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->put('agent', [
                'ip' => Request::ip(),
//                'ip-v2' => Request::getClientIp(),
                'browser' => \Browser::browserName(),
                'os' => \Browser::platformName(),
            ]);
        });

        Storage::disk('private')->buildTemporaryUrlsUsing(
            function (string $path, DateTime $expiration, array $options) {
                return URL::temporarySignedRoute(
                    'linkPrivateStorageSigned',
                    $expiration,
                    array_merge($options, ['path' => $path])
                );
            }
        );

        Field::macro('ltr' , function () {
            return $this->extraInputAttributes(['dir' => 'ltr']);
        });

    }
}
