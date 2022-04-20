<?php

namespace App\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeDomainCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain
                            {domain : the name of the domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make new domain';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('make:domain-registration', [
            'domain' => $this->argument('domain'),
        ]);

        $this->info('Please put ' . $this->argument('domain') . "DomainRegistration file to App\\Infrastructure\\Registration\\DomainRegistration");
        return 1;
    }
}
