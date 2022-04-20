<?php

namespace App\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Support\Str;

class CustomSeederMakeCommand extends SeederMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:custom-seeder
                            {name : The name of the seeder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custom path for seeder class';

    protected function getPath($name)
    {
        $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name));
        $nameOnly = $this->getNameOnly($name);
        $path = str_replace($nameOnly, '', $name);
        return app_path() . "/" . $path . $nameOnly . '.php';
    }

    protected function rootNamespace()
    {
        return 'App\\';
    }

    protected function getNameOnly($name)
    {
        $splitted = explode('/', $name);
        return end($splitted);
    }
}
