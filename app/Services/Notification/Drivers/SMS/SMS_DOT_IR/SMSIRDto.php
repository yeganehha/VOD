<?php

namespace App\Services\Notification\Drivers\SMS\SMS_DOT_IR;

use App\Services\Notification\NotificationDTO;

class SMSIRDto extends NotificationDTO
{

    public int $template;
    public array $parameters;

    public function getValidator(): array
    {
        return [
            'template' => ['required' , 'numeric'],
            'parameters' => ['required' , 'array']
        ];
    }

    public function toArray(): array
    {
        return [
            'template' => $this->template,
            'parameters' => $this->parameters,
        ];
    }
}
