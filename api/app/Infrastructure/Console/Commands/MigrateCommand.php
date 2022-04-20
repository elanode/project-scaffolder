<?php

namespace App\Infrastructure\Console\Commands;

use App\Infrastructure\Database\MigrationPaths;
use App\Infrastructure\Registration\DomainsRegistration;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Console\Migrations\MigrateCommand as BaseMigrateCommand;
use Illuminate\Database\Migrations\Migrator;

class MigrateCommand extends BaseMigrateCommand
{
    protected array $paths;

    public function __construct()
    {
        parent::__construct(app("migrator"), app(Dispatcher::class));
    }

    public function handle()
    {
        $defaultPath = $this->laravel->databasePath() . DIRECTORY_SEPARATOR . 'migrations';

        $this->paths = array_unique(array_merge([$defaultPath], DomainsRegistration::getMigrationPaths()));

        parent::handle();
    }

    protected function getMigrationPaths()
    {
        if ($this->input->hasOption('path') && $this->option('path')) {
            return collect($this->option('path'))->map(function ($path) {
                return !$this->usingRealPath()
                    ? $this->laravel->basePath() . '/' . $path
                    : $path;
            })->all();
        }

        return array_merge(
            $this->migrator->paths(),
            $this->paths
        );
    }
}
