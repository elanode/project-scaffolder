<?php

namespace App\Infrastructure\Providers;

use App\Infrastructure\Console\Commands\MigrateCommand;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\MigrationServiceProvider;

class CustomMigrationProvider extends MigrationServiceProvider
{
    public function register()
    {
        parent::register();

        $this->registerMigrateCommand();
    }

    protected function registerMigrateCommand()
    {
        $this->app->singleton('command.migrate', function ($app) {
            return new MigrateCommand($app['migrator'], $app[Dispatcher::class]);
        });
    }
}
