<?php

namespace App\Domains\Authentication\Seeders;

use App\Domains\Authentication\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        collect(RoleEnum::cases())->each(function ($role) {
            Role::create(['name' => $role, 'guard_name' => 'api']);
            Role::create(['name' => $role, 'guard_name' => 'web']);
        });
    }
}
