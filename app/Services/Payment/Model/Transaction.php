<?php

namespace App\Services\Payment\Model;

use App\Models\User;
use App\Services\Payment\Contracts\Payable;
use App\Services\Payment\Enums\PayStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property string $uuid
 * @property string $call_back_uuid
 * @property string $payable_type
 * @property int $payable_id
 * @property Payable $payable
 * @property string $ip_address
 * @property int $price
 * @property string $gateway
 * @property string $reference_id
 * @property string $reference_id2
 * @property string $card_mask
 * @property string $card_hash
 * @property PayStatus $status
 * @property Carbon $paid_at
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'payable_type', 'payable_id', 'uuid','call_back_uuid', 'ip_address', 'price',
        'gateway', 'reference_id', 'reference_id2', 'card_mask', 'card_hash',
        'status', 'paid_at', 'description'
    ];

    protected $casts = [
        'price' => 'int',
        'user_id' => 'int',
        'payable_id' => 'int',
        'paid_at' => 'datetime',
        'status' => PayStatus::class,
    ];



    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            /** @var self $model */
            do {
                $model->uuid = strtoupper(fake()->bothify('******'));
                $model->call_back_uuid = Str::uuid();
            } while ( self::query()
                ->where('uuid', $model->uuid)
                ->orWhere('call_back_uuid', $model->call_back_uuid)
                ->exists() );
        });

    }
    public function payable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
