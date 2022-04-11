<?php

namespace App\Console\Commands;

use App\Domains\Authentication\Seeders\PermissionsSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SyncPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-sync permission based on permission seeder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('db:seed', [
            '--class' => PermissionsSeeder::class
        ]);

        $this->info('Permissions re-sync with PermissionSeeder');
    }
}
