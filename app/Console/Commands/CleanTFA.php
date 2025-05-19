<?php

namespace App\Console\Commands;

use App\Repositories\Auth\TwoFARepository;
use App\Services\Auth\TwoFAService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

class CleanTFA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'clear:2fa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old 2FA keys.';


    /**
     * Execute the console command.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function handle()
    {
        /** @var TwoFARepository $repo */
        $repo = app(TwoFARepository::class);
        $repo->deleteTrashTokens(3 * 60 );
    }


}
