<?php

namespace App\Services\CDNFetchIP;

use App\Services\CDNFetchIP\Contracts\CDNInterface;
use App\Services\CDNFetchIP\Contracts\CDNFetcherIPInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class CDNFetcherIP implements CDNFetcherIPInterface
{
    public const paths = [__DIR__.'/CDNs'] ;
    public const CACHE_NAME = 'CDNFetchedIPs' ;

    public function getIP(): Collection
    {
        return cache()->get('CDNFetchedIPs' , collect([]));
    }

    public function fetchIPFromCDN(): Collection
    {
        cache()->forget(self::CACHE_NAME);
        return cache()->rememberForever(self::CACHE_NAME , function () {
            $CDNs = $this->fetchCDNs(self::paths);
            $IPs = $this->fetchIPs($CDNs);
            return $IPs;
        });
    }

    private function fetchCDNs(string|array $paths) : Collection
    {
        $CDNs = collect();
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return $CDNs;
        }

        $namespace = app()->getNamespace();
        foreach ((new Finder)->in($paths)->files() as $cdn) {
            $cdn = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($cdn->getRealPath(), realpath(app_path()).DIRECTORY_SEPARATOR)
                );
            if ( in_array( CDNInterface::class,  class_implements($cdn)) )
                $CDNs->add( $cdn );

        }
        return $CDNs;
    }

    private function fetchIPs(Collection $CDNs) : Collection
    {
        return $CDNs->map(function ($cdn) {
           return (new $cdn)->fetch();
        })->collapse();
    }

}
