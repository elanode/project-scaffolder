<?php

namespace App\Domains\Authentication\Tests\Http\Controllers\V1;

use App\Domains\Authentication\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seedDb();
        $this->testUrl = '/api/forgot-password';
    }

    public function test_it_should_send_mail()
    {
        Notification::fake();

        $user = User::first();
        $res = $this->postJson($this->testUrl, [
            "email" => $user->email
        ]);

        $res->assertStatus(200);
        $res->assertJson(["message" => "Reset link sent to email!"]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_should_keep_send_200_status_if_email_not_found()
    {
        Notification::fake();

        $res = $this->postJson($this->testUrl, [
            "email" => "emailshouldnotbefound@fourofour.com"
        ]);

        $res->assertStatus(200);
        $res->assertJson(["message" => "Reset link sent to email!"]);

        Notification::assertNothingSent();
    }
}
