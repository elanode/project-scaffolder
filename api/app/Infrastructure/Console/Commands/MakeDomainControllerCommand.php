<?php

namespace App\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeDomainControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-controller
                            {domain : the name of the domain}
                            {name : the name of the controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new domain invokable controller';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call(
            'make:controller',
            [
                'name' => "App\\Domains\\{$this->argument('domain')}\\Http\\Controllers\\{$this->argument('name')}",
                '--invokable' => true,
            ]
        );

        $this->info('Domain controller created successfully');

        return 1;
    }
}
