<?php

namespace App\Services\CDNFetchIP\CDNs;

use App\Services\CDNFetchIP\Abstracts\CDNAbstract;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class Parspack extends CDNAbstract
{

    public static bool $isActive = false;
    /**
     * Fetch all ips from CDN and return it as array
     * @return array<string>|null
     * @throws GuzzleException
     */
    public function fetch(): ?array
    {
        if ( ! self::$isActive or app()->environment() !== 'production' )
            return null;
        try {
            $rawIPs = $this->client->get('http://parspack.com/cdnips.txt')->getBody()->getContents();
            $IPs = array_filter(explode("\n", $rawIPs));
            return $IPs;
        } catch (\Exception $exception) {
            Log::error('Error In Load IPs From Parspack CDN: '.$exception->getMessage());
            return null;
        }
    }
}
