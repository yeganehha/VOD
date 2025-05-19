<?php

namespace App\Services\Notification;

use App\Models\User;
use App\Services\Notification\Contracts\ModelNotificationDTOInterface;
use App\Services\Notification\Contracts\NotificationCanMap;
use App\Services\Notification\Contracts\NotificationDriverInterface;
use App\Services\Notification\Contracts\NotificationDTOInterface;
use App\Services\Notification\Enums\NotificationPriority;
use App\Services\Notification\Jobs\sendNotification;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\App;

class NotificationManager
{
    /**
     * @param Arrayable<NotificationDTOInterface>|NotificationDTOInterface|array<NotificationDTOInterface>|NotificationCanMap $messageDTOS
     * @param User|int|string $recipient
     * @param NotificationPriority $priority
     * @param Arrayable|array $channels
     * @throws Exception
     */
    public static function queueSend(Arrayable|NotificationDTOInterface|array|NotificationCanMap $messageDTOS, User|int|string $recipient,NotificationPriority $priority, Arrayable|array $channels = []): void
    {
        if( $priority === NotificationPriority::RightNow )
            self::send($messageDTOS, $recipient, $channels);
        else
            dispatch((new sendNotification($messageDTOS, $recipient,$channels))->onQueue($priority->value));
    }

    /**
     * @param Arrayable<NotificationDTOInterface>|NotificationDTOInterface|array<NotificationDTOInterface>|NotificationCanMap $messageDTOS
     * @param User|int|string $recipient
     * @param Arrayable|array $channels
     * @throws Exception
     */
    public static function send(Arrayable|NotificationDTOInterface|array|NotificationCanMap $messageDTOS, User|int|string $recipient, Arrayable|array $channels = []): void
    {
        $channels = empty($channels) ? array_keys(config('notification.channels' , [])) : $channels;

        foreach ($channels as $channel) {
            self::sendViaChannel($channel, $messageDTOS, $recipient);
        }
    }

    /**
     * @throws Exception
     */
    protected static function sendViaChannel(string $channel,Arrayable|NotificationDTOInterface|array|NotificationCanMap $messageDTOS, User|int|string $recipient): void
    {
        $channels = config('notification.channels' , []);
        if (!isset($channels[$channel])) {
            throw new Exception("Channel ".$channel." is not configured.");
        }

        $driverName = $channels[$channel]['driver'];
        $DTO = optional($channels[$channel])['DTO'];
        $driverData = $channels[$channel]['drivers'][$driverName];
        if ( is_array($driverData) ) {
            $driverClass = optional($driverData)['handler'];
            $DTO = optional($driverData)['DTO'];
        } else {
            $driverClass = $driverData;
        }

        $driver = App::make($driverClass);

        if (!$driver instanceof NotificationDriverInterface) {
            throw new Exception("Driver ".$driverName." must implement NotificationDriverInterface.");
        }

        if ( $prepareData = self::prepareData($messageDTOS , (string) $DTO) )
            $driver->send($prepareData, $recipient);
    }

    /**
     * @throws Exception
     */
    protected static function prepareData(NotificationCanMap|NotificationDTOInterface|array|Arrayable $messageDTOS, string $DTO):NotificationDTOInterface|false
    {
        $modelToDTO = config('notification.models_DTO' , []);
        if ( $messageDTOS instanceof NotificationCanMap ) {
            if ( ! isset($modelToDTO[get_class($messageDTOS)]) )
                throw new Exception("DTO of ".get_class($messageDTOS)." is not configured.");
            if ( is_string($modelToDTO[get_class($messageDTOS)])) {
                $dto = App::make($modelToDTO[get_class($messageDTOS)]);

                if (!$dto instanceof ModelNotificationDTOInterface) {
                    throw new Exception("DTO " . $dto . " must implement ModelNotificationDTOInterface.");
                }
                $messageDTOS = $dto->prepareData($messageDTOS);
            } else
                $messageDTOS = $modelToDTO[get_class($messageDTOS)];
        }
        if ( $messageDTOS instanceof Arrayable or is_array($messageDTOS)) {
            if ( $messageDTOS instanceof Arrayable )
                $messageDTOS = $messageDTOS->toArray();
            foreach ($messageDTOS as $messageDTO) {
                if (self::isDTOValid($messageDTO , $DTO) )
                    return $messageDTO;
            }
        } elseif ( self::isDTOValid($messageDTOS , $DTO) ) {
            return $messageDTOS;
        }
        return false;
    }

    protected static function isDTOValid($object , $DTO): bool
    {
        return $object instanceof NotificationDTOInterface and is_a($object,$DTO, true) and $object->isValid();
    }
}
