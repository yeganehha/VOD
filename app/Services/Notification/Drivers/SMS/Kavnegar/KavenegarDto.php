<?php

namespace App\Services\Notification\Drivers\SMS\Kavnegar;

use App\Services\Notification\Contracts\NotificationDTOInterface;
use App\Services\Notification\NotificationDTO;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Validator;

class KavenegarDto extends NotificationDTO
{
    public string $template;
    public string $token;
    public ?string $token2 = null;
    public ?string $token3 = null;

    public function getValidator(): array
    {
        return [
            'template' => ['required' , 'string' , 'max:255', 'regex:/^\S*$/u'],
            'token' => ['required' , 'string' , 'max:255' , 'regex:/^\S*$/u'],
            'token2' => ['nullable' , 'string' , 'max:255' , 'regex:/^\S*$/u'],
            'token3' => ['nullable' , 'string' , 'max:255' , 'regex:/^\S*$/u'],
        ];
    }

    public function toArray(): array
    {
        return [
            'template' => $this->template,
            'token' => $this->token,
            'token2' => $this->token2,
            'token3' => $this->token3,
        ];
    }
}
