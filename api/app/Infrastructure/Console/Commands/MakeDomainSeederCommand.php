<?php

namespace App\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeDomainSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-seeder
                            {domain : The name of the domain}
                            {name : The name of the seeder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make new domain seeder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('make:custom-seeder', [
            'name' => "App\\Domains\\{$this->argument('domain')}\\Database\\Seeders\\{$this->argument('name')}",
        ]);
        $this->info("Domain seeder created successfully.");
        return 1;
    }
}
