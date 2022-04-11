<?php

namespace App\Domains\Authentication\Seeders;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            Role::create(['name' => $role->value, 'guard_name' => '*']);
        });
    }
}
