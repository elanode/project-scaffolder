<?php

namespace App\Domains\Authentication\Tests\Http\Controllers\V1;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttachUserToControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seedDb();
        $this->testUrl = '/api/authentication/users/attach-roles';
    }

    public function test_it_should_use_permission_middleware()
    {
        $this->assertRouteUsesMiddleware('authentication.users.attach-roles', ['permission:authentication attach user to role']);
    }

    public function test_it_can_attach_role_to_user()
    {
        $this->setActingAs(RoleEnum::SUPERADMIN);
        $user = User::find(3);

        $res = $this->postJson($this->testUrl, [
            'user_id' => $user->id,
            'role_names' => [
                RoleEnum::ADMIN->value,
                RoleEnum::USER->value
            ],
        ]);

        $res->assertStatus(200);

        $user->refresh();

        $this->assertEquals(2, $user->roles->count());
        $this->assertTrue($user->hasRole(RoleEnum::ADMIN->value));
        $this->assertTrue($user->hasRole(RoleEnum::USER->value));
        $this->assertFalse($user->hasRole(RoleEnum::SUPERADMIN->value));
    }
}
