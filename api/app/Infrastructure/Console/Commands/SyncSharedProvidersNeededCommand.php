<?php

namespace App\Infrastructure\Console\Commands;

use App\Infrastructure\Registration\DomainsRegistration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class SyncSharedProvidersNeededCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:providers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers all the needed providers based on Infrastructure/DomainsRegistration.php';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $serviceProviders = DomainsRegistration::usedSharedServiceProviders();
        $configProviders = config('app.providers');
        $configProviders = array_unique(array_merge($configProviders, $serviceProviders));

        $configProviders = array_map(function ($provider) {
            return $provider . '::class';
        }, $configProviders);

        $path = config_path('app.php');
        $contents = File::get($path);
        $contents = preg_replace('/\/\/START(.*?)\/\/END[\s\S]];/s', '', $contents);

        $contents = str_replace(
            '$providers = [',
            '$providers = [' . ' //START' . PHP_EOL . '    ' .  implode(',' . PHP_EOL . '    ', $configProviders) . PHP_EOL . '    //END'  . PHP_EOL .  '];',
            $contents
        );
        File::put($path, $contents);

        $this->info('Providers synced successfully with DomainsRegistration::usedSharedServiceProviders()');
    }
}
