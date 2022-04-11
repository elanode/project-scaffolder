<?php

namespace Tests\Feature\Domains\Authentication\Actions;

use App\Domains\Authentication\Actions\AttachRoleToUserAction;
use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\User;
use App\Domains\Authentication\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AttachRoleToUserActionTest extends TestCase
{
    use RefreshDatabase;

    /** @var AttachRoleToUserAction */
    protected $action;

    /** @var User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed', [
            '--class' => RoleSeeder::class
        ]);

        $this->action = new AttachRoleToUserAction;

        $this->user = User::factory()->create();
    }

    public function test_it_should_attach_role_to_user()
    {
        $this->action->run($this->user->id, RoleEnum::ADMIN);

        $userRoles = $this->user->roles->pluck('name')->toArray();

        $this->assertTrue(in_array(RoleEnum::ADMIN->value, $userRoles));
    }

    public function test_it_can_attach_multiple_roles_to_user()
    {
        $this->action->run($this->user->id, RoleEnum::ADMIN, RoleEnum::SUPERADMIN);

        $userRoles = $this->user->roles->pluck('name')->toArray();

        $this->assertTrue(in_array(RoleEnum::ADMIN->value, $userRoles));
        $this->assertTrue(in_array(RoleEnum::SUPERADMIN->value, $userRoles));
    }
}
