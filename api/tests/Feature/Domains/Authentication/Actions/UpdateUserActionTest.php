<?php

namespace Tests\Feature\Domains\Authentication\Actions;

use App\Domains\Authentication\Actions\UpdateUserAction;
use App\Domains\Authentication\Dtos\UserDto;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_updates_user()
    {
        $data = [
            'name' => '::updated::'
        ];
        $user = User::factory()->create();

        $userDto = new UserDto(
            $data['name'],
            $user->email,
        );

        (new UpdateUserAction)->run($user->id, $userDto);

        $user->refresh();
        $this->assertEquals($data['name'], $user->name);
    }

    public function test_it_should_not_update_password_if_not_provided()
    {
        $user = User::factory()->create();

        $userDto = new UserDto(
            $user->name,
            $user->email
        );

        (new UpdateUserAction)->run($user->id, $userDto);

        $valid = auth()->attempt([
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertTrue($valid);
    }

    public function test_it_can_update_password_if_provided()
    {
        $user = User::factory()->create();

        $userDto = new UserDto(
            $user->name,
            $user->email,
            '::newPassword::'
        );

        (new UpdateUserAction)->run($user->id, $userDto);

        $valid = auth()->attempt([
            'email' => $user->email,
            'password' => '::newPassword::'
        ]);
        $this->assertTrue($valid);
    }
}
