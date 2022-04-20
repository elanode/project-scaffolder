<?php

namespace Tests\Feature\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateUserAccountControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seedDb();
        $this->testUrl = '/api/authentication/users/';
    }

    public function test_un_authorized_user_can_not_update_another_user()
    {
        $this->setActingAs(RoleEnum::ADMIN);

        $randomUser = User::role(RoleEnum::USER->value)->first();

        $res = $this->putJson($this->testUrl . $randomUser->id, [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'hacked'
        ]);

        $res->assertStatus(403);
    }

    public function test_superadmin_can_update_user()
    {
        $this->setActingAs(RoleEnum::SUPERADMIN);

        $randomUser = User::role(RoleEnum::USER->value)->first();
        $res = $this->putJson($this->testUrl . $randomUser->id, [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'changed'
        ]);

        $res->assertStatus(200);

        $randomUser->refresh();

        $this->assertEquals('test', $randomUser->name);
        $this->assertEquals('test@test.com', $randomUser->email);
        $this->assertTrue(Hash::check('changed', $randomUser->password));
    }
}
