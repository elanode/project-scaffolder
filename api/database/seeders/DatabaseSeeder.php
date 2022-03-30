<?php

namespace Database\Seeders;

use App\Domains\Authentication\Seeders\UserFakeSeeder;
use Illuminate\Database\Seeder;

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
            UserFakeSeeder::class
        ]);
    }
}
