<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'key';
    public $timestamps = false;
    protected $fillable = [
        'key',
        'value'
    ];


    public static function boot(): void
    {
        parent::boot();
        static::created(function ($model) {
            cache()->forget('setting_'.md5($model->key));
            cache()->rememberForever('setting_'.md5($model->key) , function () use ($model) {
                return $model->value;
            });
        });
        static::updated(function ($model) {
            cache()->forget('setting_'.md5($model->key));
            cache()->rememberForever('setting_'.md5($model->key) , function () use ($model) {
                return $model->value;
            });
        });
        static::deleted(function ($model) {
            cache()->forget('setting_'.md5($model->key));
        });
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => unserialize($value),
            set: fn (mixed $value) => serialize($value),
        );
    }
}
