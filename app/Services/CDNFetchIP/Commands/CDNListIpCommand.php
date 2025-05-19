<?php

namespace App\Services\CDNFetchIP\Commands;

use App\Services\CDNFetchIP\Contracts\CDNFetcherIPInterface;
use App\Services\CDNFetchIP\CDNFetcherIP;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'cdn:list')]
class CDNListIpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdn:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list fetched IP from CDN';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var CDNFetcherIPInterface $CDNService */
        $CDNService = new CDNFetcherIP();
        $ips = $CDNService->getIP();
        $ips = array_map(fn ($value): array => [$value], $ips->toArray());
        $this->table(['Address'], $ips);
    }
}
