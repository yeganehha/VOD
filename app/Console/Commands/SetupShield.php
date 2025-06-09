<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupShield extends Command
{
    protected $signature = 'setup:shield';

    protected $description = 'Generate shield permissions and assign super admin role';

    public function handle(): int
    {
        $this->info('Generating permissions...');
        Artisan::call('shield:generate', ['--all' => true]);
        $this->line(Artisan::output());

        $this->info('Assigning Super Admin role...');
        Artisan::call('shield:super-admin', ['--user' => 1]);
        $this->line(Artisan::output());

        $this->info('Shield setup complete.');

        return Command::SUCCESS;
    }
}
