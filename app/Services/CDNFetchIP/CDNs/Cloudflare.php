<?php

namespace App\Services\CDNFetchIP\CDNs;

use App\Services\CDNFetchIP\Abstracts\CDNAbstract;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class Cloudflare extends CDNAbstract
{

    public static bool $isActive = false;
    /**
     * Fetch all ips from CDN and return it as array
     * @return array<string>|null
     * @throws GuzzleException
     */
    public function fetch(): ?array
    {
        if ( ! self::$isActive or app()->environment() !== 'production')
            return null;
        try {
            $rawIPs = $this->client->get('http://www.cloudflare.com/ips-v4')->getBody()->getContents();
            $IPsV4 = array_filter(explode("\n", $rawIPs));
            $rawIPs = $this->client->get('http://www.cloudflare.com/ips-v6')->getBody()->getContents();
            $IPsV6 = array_filter(explode("\n", $rawIPs));
            return array_merge( (array) $IPsV4 , (array) $IPsV6);
        } catch (\Exception $exception) {
            Log::error('Error In Load IPs From Cloudflare CDN: '.$exception->getMessage());
            return null;
        }
    }
}
