<?php

namespace App\Domains\Authentication\Tests\Http\Controllers\V1;

use App\Domains\Authentication\Actions\CreateUserAction;
use App\Domains\Authentication\Enums\RoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateNewUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seedDb();
        $this->testUrl = '/api/authentication/users';
    }

    public function test_it_should_use_appropriate_permission_middleware()
    {
        $this->assertRouteUsesMiddleware('authentication.users.create', ['permission:authentication create new user']);
    }

    public function test_it_should_call_create_new_user_action()
    {
        $spy = $this->spy(CreateUserAction::class)->makePartial();
        $this->app->instance(CreateUserAction::class, $spy);

        $this->setActingAs(RoleEnum::SUPERADMIN);

        $res = $this->postJson($this->testUrl, [
            'name' => 'Test User',
            'email' => 'testuser@test.com',
            'password' => '::minimum8MixedCharsLettersNumbers@Symbols::',
            'password_confirmation' => '::minimum8MixedCharsLettersNumbers@Symbols::',
        ]);

        $res->assertStatus(201);
        $res->assertJsonStructure($this->successResponseStructure);

        $spy->shouldHaveReceived('run');
    }
}
