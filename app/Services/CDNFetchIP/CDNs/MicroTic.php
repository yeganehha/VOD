<?php

namespace App\Services\CDNFetchIP\CDNs;

use App\Services\CDNFetchIP\Abstracts\CDNAbstract;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class MicroTic extends CDNAbstract
{

    public static bool $isActive = true;
    /**
     * Fetch all ips from CDN and return it as array
     * @return array<string>|null
     * @throws GuzzleException
     */
    public function fetch(): ?array
    {
        if ( ! self::$isActive or app()->environment() !== 'production' )
            return null;
        return [
            '192.168.0.0/16',
            '127.0.0.0/31'
        ];
    }
}
