<?php

namespace App\Services\Payment\Provider;

use App\Services\Payment\Enums\PayStatus;
use App\Services\Payment\Model\Transaction;
use App\Services\Payment\Model\TransactionPolicy;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{

    public function boot():void
    {
        Gate::policy(Transaction::class, TransactionPolicy::class);
        Blueprint::macro('addPaymentFields', function () {
            /** @var Blueprint $this */
            $this->decimal('price', 15)->default(0);
            $this->string('paid_status',50)->default(PayStatus::INIT->value);
            $this->dateTime('paid_at')->nullable();
        });

        $this->loadMigrationsFrom(app_path('Services/Payment/Migrations'));

        foreach (glob(app_path('Services/Payment/routes/*.php')) as $routeFile) {
            $this->loadRoutesFrom($routeFile);
        }
        $this->mergeConfigFrom(app_path('Services/Payment/config/payment.php') , 'payment');
    }
}
