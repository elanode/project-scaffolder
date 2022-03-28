<?php

namespace Database\Seeders;

use App\Domains\Shared\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123123123')
        ]);

        User::factory(10)->create();
    }
}
