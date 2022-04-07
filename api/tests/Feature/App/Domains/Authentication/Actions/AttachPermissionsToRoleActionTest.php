<?php

namespace Tests\Feature\App\Domains\Authentication\Actions;

use App\Domains\Authentication\Actions\AttachPermissionsToRoleAction;
use App\Domains\Authentication\Models\Permission;
use App\Domains\Authentication\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttachPermissionsToRoleActionTest extends TestCase
{
    use RefreshDatabase;

    /** @var AttachPermissionsToRoleAction */
    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = new AttachPermissionsToRoleAction;
    }

    public function test_it_should_sync_permissions_to_role()
    {
        $role = Role::create(['name' => 'admin']);

        $permissionOne = Permission::create(['name' => 'permissionOne']);
        $permissionTwo = Permission::create(['name' => 'permissionTwo']);

        $this->action->run($role->id, [$permissionOne->id, $permissionTwo->id]);

        $rolePermissions = $role->permissions()->get();

        $this->assertTrue($rolePermissions->count() == 2);
        $this->assertTrue(in_array($permissionOne->name, $rolePermissions->pluck('name')->toArray()));
        $this->assertTrue(in_array($permissionTwo->name, $rolePermissions->pluck('name')->toArray()));
    }
}
