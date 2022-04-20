<?php

namespace Database\Seeders;

use App\Domains\Authentication\Database\Seeders\PermissionsSeeder;
use App\Domains\Authentication\Database\Seeders\RoleSeeder;
use App\Domains\Authentication\Database\Seeders\UserFakeSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            PermissionsSeeder::class
        ]);

        if (config('app.env') === 'local' || config('app.env') === 'testing') {
            $this->call([
                UserFakeSeeder::class
            ]);

            Artisan::call('passport:install -n');
            Artisan::call('passport:client --public --user_id=1 --name=nuxtclient --redirect_uri=http://localhost:3000/oauth/login --no-interaction');
        }
    }
}
