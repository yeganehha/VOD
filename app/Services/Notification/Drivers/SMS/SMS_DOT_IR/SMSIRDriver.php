<?php

namespace App\Services\Notification\Drivers\SMS\SMS_DOT_IR;

use App\Models\User;
use App\Services\Helper;
use App\Services\Notification\Contracts\NotificationDriverInterface;
use App\Services\Notification\Contracts\NotificationDTOInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class SMSIRDriver implements NotificationDriverInterface
{


    public function send(SMSIRDto|NotificationDTOInterface $data, User|string|int $recipient): void
    {
        $mobile = (is_a($recipient,User::class,true) ? $recipient->phone : $recipient);
        Log::info("SMSIR :SMS sent to ".$mobile." : $data->template" , [$data->parameters]);
        $this->sendRequest('POST', 'send/verify', [
            'json' => [
                'mobile' => $mobile ,
                'templateId' => $data->template,
                'parameters' => array_map(function($index , $parameter ){
                    return ['name' => $index, 'value' => $parameter];
                },array_keys($data->parameters) , array_values($data->parameters)),
            ]
        ]);
    }

    private static function sendRequest($method, $uri, $options = [])
    {
        try {
            $client = new Client([
                'base_uri' =>'https://api.sms.ir/v1/',
                'headers' => [
                    'X-API-KEY' => Helper::setting('SMS_IR_API_KEY' ,config('services.SMS_IR.api_key')),
                    'Accept' => 'application/json',
                ]
            ]);
            $response = $client->request($method, $uri, array_merge($options , ['http_errors' => false]));

            $body = json_decode($response->getBody(), true);
            $statusCode = $response->getStatusCode();
            $message = $body['message'] ?? null;

            switch ($statusCode) {
                case 200:
                    $status = $body['status'] ?? null;
                    if ( ! $status ) {
                        Log::error("SMSIR (".$statusCode."): ".$message  );
                    } else {
                        Log::info("SMSIR (".$statusCode.") - success: ",[optional($body)['data']]  );
                        return  optional($body)['data'] ;
                    }
                    break;
                case 400:
                    Log::error("SMSIR (".$statusCode."): ".$message  );
                    break;
                case 401:
                    Log::error("SMSIR (".$statusCode."): Unauthorized access"  );
                    break;
                case 403:
                    Log::error("SMSIR (".$statusCode."): Access Denied"  );
                    break;
                case 429:
                    Log::error("SMSIR (".$statusCode."): Too Many Requests"  );
                    break;
                case 500:
                    Log::error("SMSIR (".$statusCode."): Internal Server Error"  );
                    break;
                default:
                    Log::error("SMSIR (".$statusCode."): An unexpected error occurred");
                    break;
            }
            return true;
        } catch (GuzzleException|Exception $e) {
            Log::error("An unexpected error occurred when send sms to SMS.ir: " . $e->getMessage());
            return false;
        }
    }

    public static function getCredit()
    {
        return self::sendRequest('GET', 'credit');
    }

    public function getLines()
    {
        return self::sendRequest('GET', 'line');
    }
}
