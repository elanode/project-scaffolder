<?php

namespace App\Domains\Authentication\Database\Seeders;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserFakeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123123123')
        ]);

        $user->assignRole(RoleEnum::SUPERADMIN->value);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123123123')
        ]);

        $user->assignRole(RoleEnum::ADMIN->value);

        $users = User::factory(10)->create();

        foreach ($users as $defaultUser) {
            $defaultUser->assignRole(RoleEnum::USER->value);
        }
    }
}
