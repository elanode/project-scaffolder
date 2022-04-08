<?php

namespace Database\Seeders;

use App\Domains\Authentication\Seeders\PermissionsSeeder;
use App\Domains\Authentication\Seeders\RoleSeeder;
use App\Domains\Authentication\Seeders\UserFakeSeeder;
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

        $this->call([
            UserFakeSeeder::class
        ]);

        Artisan::call('passport:install -n');
        Artisan::call('passport:client --public --user_id=1 --name=nuxtclient --redirect_uri=http://localhost:3000/oauth/login --no-interaction');
    }
}
