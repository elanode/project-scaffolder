<?php

namespace App\Domains\Authentication\Seeders;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\Permission;
use App\Domains\Authentication\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Format
         * 
         * 'DomainName' => [
         *     'controller class
         * ]
         * 
         * e.g. 
         * 'authentication' => [
         *     'register user
         * ]
         */
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();

        $rolesGroup = [
            RoleEnum::ADMIN->value => [
                'authentication' => [
                    'login'
                ]
            ],
            RoleEnum::USER->value => [
                'authentication' => [
                    'login'
                ]
            ]
        ];

        $rolesGroup[RoleEnum::SUPERADMIN->value] = array_merge(
            $rolesGroup[RoleEnum::ADMIN->value],
            $rolesGroup[RoleEnum::USER->value],
        );

        foreach ($rolesGroup as $roleName => $group) {
            $createdPermissions = collect();

            foreach ($group as $domainName => $controllerNames) {
                foreach ($controllerNames as $controllerName) {
                    $permissionName = "$domainName $controllerName";
                    $permission = Permission::updateOrCreate(['name' => $permissionName, 'guard_name' => '*']);
                    $createdPermissions->push($permission);
                }
            }

            $role = Role::findByName($roleName);
            $role->syncPermissions($createdPermissions);
        }
    }
}
