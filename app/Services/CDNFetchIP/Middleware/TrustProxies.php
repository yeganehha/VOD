<?php

namespace App\Services\CDNFetchIP\Middleware;

use App\Services\CDNFetchIP\CDNFetcherIP;
use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Request as RequestAlias;

class TrustProxies extends Middleware
{

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        RequestAlias::HEADER_X_FORWARDED_FOR |
        RequestAlias::HEADER_X_FORWARDED_HOST |
        RequestAlias::HEADER_X_FORWARDED_PORT |
        RequestAlias::HEADER_X_FORWARDED_PROTO |
        RequestAlias::HEADER_X_FORWARDED_AWS_ELB;


    protected function setTrustedProxyIpAddresses(Request $request): void
    {
        $this->setTrustedProxyCDNS($request);

        parent::setTrustedProxyIpAddresses($request);
    }

    private function setTrustedProxyCDNS(Request $request): void
    {

        $cachedProxies = Cache::get(CDNFetcherIP::CACHE_NAME, (new CDNFetcherIP())->fetchIPFromCDN());

        if ($cachedProxies->count() > 0) {
            $this->proxies = array_merge((array) $this->proxies, $cachedProxies->toArray());
        }
    }

}
