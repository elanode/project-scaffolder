<?php

namespace App\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeDomainTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-test
                            {domain : the name of the domain}
                            {test : the name of the test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make new domain test';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call(
            'make:custom-test',
            [
                'name' => "App\\Domains\\{$this->argument('domain')}\\Tests\\{$this->argument('test')}",
            ]
        );

        $this->info('Domain test created successfully');

        return 1;
    }
}
