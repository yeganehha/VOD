<?php

namespace App\Services\Notification;

use App\Services\Notification\Contracts\NotificationDTOInterface;
use Illuminate\Support\Facades\Validator;

/**
 * @method array getValidator()
 * @property array $validator
 */
abstract class NotificationDTO implements NotificationDTOInterface
{
    public function isValid(): bool
    {
        $validator = Validator::make($this->toArray(), method_exists($this, 'getValidator') ? $this->getValidator() : (property_exists($this , 'validator') ? $this->validator : []) );
        return ! $validator->fails();
    }

    public static function init(): static
    {
        return new static();
    }

    public function __call(string $name, array $arguments)
    {
        if ( property_exists($this , $name) ){
            $this->{$name} = $arguments[0];
        }
        return $this;
    }
}
