<?php

namespace App\Domains\Authentication\Tests\Http\Controllers\V1;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TerminateUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seedDb();
        $this->testUrl = '/api/authentication/users/terminate';
    }

    public function test_it_should_use_appropriate_middleware()
    {
        $this->assertRouteUsesMiddleware('authentication.users.terminate',  ['permission:authentication terminate any user']);
    }

    public function test_it_can_terminate_users_by_ids()
    {
        $this->setActingAs(RoleEnum::SUPERADMIN);
        $res = $this->postJson($this->testUrl, ['user_ids' => [2, 3]]);

        $res->assertOk()
            ->assertJson([
                'status' => 'success',
                'message' => 'Users terminated',
            ]);

        $this->assertTrue(User::find(2)->is_terminated);
        $this->assertTrue(User::find(3)->is_terminated);
    }
}
