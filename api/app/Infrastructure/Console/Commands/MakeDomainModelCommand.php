<?php

namespace App\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeDomainModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-model 
                            {domain : the name of the domain}
                            {model : the name of the model}
                            {--m : Whether the job should be queued}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make new domain model';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call(
            'make:model',
            [
                'name' => "App\\Domains\\{$this->argument('domain')}\\Models\\{$this->argument('model')}",
            ]
        );

        Artisan::call(
            'make:migration',
            [
                'name' => "create{$this->argument('model')}s_table",
                '--path' => "app/Domains/{$this->argument('domain')}/Database/Migrations",
            ]
        );

        Artisan::call(
            'make:domain-seeder',
            [
                'domain' => $this->argument('domain'),
                'name' => "{$this->argument('model')}Seeder",
            ]
        );

        Artisan::call(
            'make:domain-resource',
            [
                'domain' => $this->argument('domain'),
                'name' => "{$this->argument('model')}Resource",
            ]
        );

        $this->info('Domain model with migration, seeder, and resource created successfully');

        return 1;
    }
}
