<?php

namespace Tests\Feature\App\Domains\Authentication\Actions;

use App\Domains\Authentication\Actions\CreateNewPermissionAction;
use App\Domains\Authentication\Dtos\PermissionDto;
use App\Domains\Authentication\Models\Permission;
use App\Domains\Authentication\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateNewPermissionActionTest extends TestCase
{
    use RefreshDatabase;

    /** @var CreateNewPermissionAction */
    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = new CreateNewPermissionAction;
    }

    public function test_it_should_create_new_permission()
    {
        $permission = new PermissionDto(":test:", null);

        $this->action->run($permission);

        $actual = Permission::latest('id')->first();

        $this->assertEquals(":test:", $actual->name);
    }

    public function test_it_can_sync_to_roles()
    {
        $roleTestOne = Role::create(['name' => 'roletest1']);
        $roleTestTwo = Role::create(['name' => 'roletest2']);

        $permission = new PermissionDto(":test:", [1, 2]);

        $this->action->run($permission);

        $permissionsOne = $roleTestOne->permissions()->pluck('name')->toArray();
        $permissionsTwo = $roleTestTwo->permissions()->pluck('name')->toArray();

        $this->assertTrue(in_array(':test:', $permissionsOne));
        $this->assertTrue(in_array(':test:', $permissionsTwo));
    }
}
