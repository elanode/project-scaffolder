<?php

namespace App\Infrastructure\Console\Commands;

use Illuminate\Foundation\Console\TestMakeCommand;
use Illuminate\Support\Str;

class MakeTestCommand extends TestMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:custom-test';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'make:custom-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new test class. e.g. make:custom-test App\\Domains\\\Authentication\\\Tests\\\Actions\\\TerminateUserActionTest';

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $path = base_path() . '/app' . str_replace('\\', '/', $name) . '.php';

        return $path;
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return 'App';
    }
}
