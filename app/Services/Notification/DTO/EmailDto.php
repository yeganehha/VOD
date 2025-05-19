<?php

namespace App\Services\Notification\DTO;

use App\Services\Notification\NotificationDTO;
use Illuminate\Contracts\Support\Renderable;

class EmailDto extends NotificationDTO
{
    public string $subject;
    public string|Renderable $body;

    protected array $validator = [
        'subject' => ['required' , 'string' , 'max:255'],
        'body' => ['required' , 'string'],
    ];

    public function toArray(): array
    {
        return [
            'subject' => $this->subject,
            'body' => $this->body instanceof renderable ? $this->body->render() : $this->body
        ];
    }
}
