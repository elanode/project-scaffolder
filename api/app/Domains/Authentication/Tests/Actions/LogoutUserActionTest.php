<?php

namespace Tests\Feature\Domains\Authentication\Actions;

use App\Domains\Authentication\Actions\LogoutUserAction;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\Token;
use Tests\TestCase;

class LogoutUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install', ['--no-interaction' => true]);
    }

    public function test_it_should_revoke_access_tokens()
    {
        /** @var User */
        $user = User::factory()->create();

        $user->createToken('test')->accessToken;
        $token = $user->tokens()->first();

        (new LogoutUserAction)->run($user);

        $token->refresh();
        $this->assertTrue($token->revoked);
    }
}
