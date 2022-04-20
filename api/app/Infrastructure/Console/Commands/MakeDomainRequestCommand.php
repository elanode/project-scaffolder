<?php

namespace App\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeDomainRequestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-request
                            {domain : the name of the domain}
                            {name : the name of the request}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes new domain request';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call(
            'make:request',
            [
                'name' => "App\\Domains\\{$this->argument('domain')}\\Http\\Requests\\{$this->argument('name')}",
            ]
        );
        $this->info("Domain request created successfully");

        return 1;
    }
}
