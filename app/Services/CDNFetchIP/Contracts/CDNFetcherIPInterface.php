<?php

namespace App\Services\CDNFetchIP\Contracts;

use Illuminate\Support\Collection;

interface CDNFetcherIPInterface
{

    /**
     * get list of ips
     * @return Collection
     */
    public function getIP() : Collection;
    /**
     * get list of ips
     * @return Collection
     */
    public function fetchIPFromCDN() : Collection;
}
