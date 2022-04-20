<?php

namespace App\Infrastructure\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeDomainRegistrationCommand extends GeneratorCommand
{
    protected $signature = 'make:domain-registration
                            {domain : the name of the domain}';

    protected $type = "Domain Registration";

    protected $description = 'Make new domain registration';

    protected function getStub()
    {
        return app_path() . '/Infrastructure/Console/Stubs/domain-registration.stub';
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $path = $this->laravel['path'] . '/Domains/' . $this->argument('domain')  . str_replace('\\', '/', $name) . '.php';

        return $path;
    }

    protected function getNameInput()
    {
        $name = trim($this->argument('domain') . 'DomainRegistration');

        return $name;
    }

    protected function rootNamespace()
    {
        return 'App';
    }

    protected function getNamespace($name)
    {
        $namespace = trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\') . '\\Domains\\' . ucfirst($this->argument('domain'));

        return $namespace;
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace("App\\", "", $name);

        return str_replace(['DummyClass', '{{ class }}', '{{class}}'], $class, $stub);
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceDomain($stub, $name)->replaceClass($stub, $name);
    }

    protected function replaceDomain(&$stub, $name)
    {
        $stub = str_replace('{{domain}}', $this->argument('domain'), $stub);

        return $this;
    }
}
