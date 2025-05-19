<?php

namespace App\Services\CDNFetchIP\Commands;

use App\Services\CDNFetchIP\Contracts\CDNFetcherIPInterface;
use App\Services\CDNFetchIP\CDNFetcherIP;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'cdn:fetch')]
class CDNFetchIPCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdn:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch IP from CDN';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var CDNFetcherIPInterface $CDNService */
        $CDNService = new CDNFetcherIP();
        $ips = $CDNService->fetchIPFromCDN();
        $this->components->info(sprintf('%s IP fetch successfully.', $ips->count()));
    }
}
