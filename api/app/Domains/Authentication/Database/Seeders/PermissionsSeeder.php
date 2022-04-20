<?php

namespace App\Domains\Authentication\Database\Seeders;

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
         *     'controller class / permission name
         * ]
         * 
         * e.g. 
         * 'authentication' => [
         *     'register user'
         * ]
         * 
         * e.g. result
         * 'authentication register user'
         */
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();

        $rolesGroup = [
            RoleEnum::ADMIN->value => [
                'authentication' => [
                    'get all user',
                ],
                'uploader' => [
                    'create new motor vehicle risk',
                    'upload bulk motor vehicle risks',
                    'get all motor vehicle risks',
                    'delete motor vehicle risks'
                ]
            ],
            RoleEnum::USER->value => []
        ];

        $unattachedPermissions = [
            'authentication' => [
                'update all user',
                'terminate any user',
                'create new user',
                'attach user to role'
            ],
        ];

        foreach ($unattachedPermissions as $domainName => $permissions) {
            foreach ($permissions as $permission) {
                $permissionName = "$domainName $permission";
                $permission = Permission::updateOrCreate(['name' => $permissionName, 'guard_name' => '*']);
            }
        }

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
