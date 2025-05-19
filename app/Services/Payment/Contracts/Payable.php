<?php

namespace App\Services\Payment\Contracts;

use App\Services\Payment\Enums\PayStatus;
use App\Services\Payment\Model\Transaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

/**
 * @property string $pay_link
 * @property Collection<Transaction> $transactions
 * @method string getPayableUUIDVariable()
 * @method string getPayablePriceVariable()
 * @method int getPayableUserIdVariable()
 * @method PayStatus getPayableStatus()
 */
interface Payable
{

//    public static function bootPayable();
    public function transactions(): MorphMany;
    public function getPrimaryKeyValue(): int;
    public function getPriceValue(): int;
    public function getUUIDValue(): ?string;

    public function getUserIdValue(): int;

    public function getPayLinkAttribute() :string;
    public function geResourceViewLink() :string;
    public function geResourceViewLabel() :string;
    public function getStatusValue(): PayStatus;

    public function getUUIDVariable(): string;
    public function purchase(Transaction $transaction): bool;

}
