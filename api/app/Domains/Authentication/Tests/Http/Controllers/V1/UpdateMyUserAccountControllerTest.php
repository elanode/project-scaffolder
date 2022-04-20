<?php

namespace Tests\Feature\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Enums\RoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateMyUserAccountControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seedDb();
        $this->testUrl = '/api/authentication/users/my-account/update';
    }

    public function test_it_should_updates_own_account()
    {
        $this->setActingAs(RoleEnum::ADMIN);

        $res = $this->putJson($this->testUrl, [
            'name' => '::updated::',
            'email' => 'emailupdate@test.com',
            'password' => null
        ]);

        $res->assertStatus(200);
    }

    public function test_it_should_not_updates_password_if_not_specified()
    {
        $user = $this->setActingAs(RoleEnum::ADMIN);
        $user->password = Hash::make('dontchange');
        $user->save();

        $res = $this->putJson($this->testUrl, [
            'name' => '::updated::',
            'email' => 'emailupdate@test.com',
            'password' => null
        ]);

        $res->assertStatus(200);

        $this->assertTrue(Hash::check('dontchange', $user->password));
    }

    public function test_it_can_update_password()
    {
        $user = $this->setActingAs(RoleEnum::ADMIN);
        $res = $this->putJson($this->testUrl, [
            'name' => 'Hello',
            'email' => 'email@test.com',
            'password' => 'updated'
        ]);

        $res->assertStatus(200);

        $user->refresh();
        $this->assertTrue(Hash::check('updated', $user->password));
    }
}
