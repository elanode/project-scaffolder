<?php

namespace App\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeDomainResourceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-resource
                            {domain : the name of the domain}
                            {name : the name of the resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes new domain resource';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call(
            'make:resource',
            [
                'name' => "App\\Domains\\{$this->argument('domain')}\\Http\\Resources\\{$this->argument('name')}",
            ]
        );
        $this->info('Domain resource created successfully');
        return 1;
    }
}
