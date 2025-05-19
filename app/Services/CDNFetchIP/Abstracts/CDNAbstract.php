<?php

namespace App\Services\CDNFetchIP\Abstracts;

use App\Services\CDNFetchIP\Contracts\CDNInterface;
use GuzzleHttp\Client;

abstract class CDNAbstract implements CDNInterface
{
    public static bool $isActive = true;
    protected Client $client ;
    protected static int $timeout = 10 ;


    public function __construct()
    {
        $this->client = new Client(['timeout' => self::$timeout]);
    }
}
