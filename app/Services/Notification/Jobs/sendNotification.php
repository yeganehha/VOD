<?php

namespace App\Services\Notification\Jobs;

use \App\Services\Notification\Contracts\NotificationCanMap;
use App\Models\User;
use App\Services\Notification\Contracts\NotificationDTOInterface;
use App\Services\Notification\NotificationManager;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Arrayable|NotificationDTOInterface|array|NotificationCanMap $messageDTOS;
    protected  User|int|string $recipient;
    protected  Arrayable|array $channels;

    /**
     * Create a new job instance.
     */
    public function __construct(Arrayable|NotificationDTOInterface|array|NotificationCanMap $messageDTOS, User|int|string $recipient, Arrayable|array $channels = [])
    {
        $this->messageDTOS = $messageDTOS;
        $this->recipient = $recipient;
        $this->channels = $channels;
    }

    /**
     * Execute the job.
     * @throws Exception
     */
    public function handle(): void
    {
        NotificationManager::send($this->messageDTOS , $this->recipient,$this->channels);
    }
}
