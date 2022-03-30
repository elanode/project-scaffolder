<?php

namespace Tests\Feature\Domains\Authentication\Actions;

use App\Domains\Authentication\Actions\CreateUserAction;
use App\Domains\Authentication\Dtos\UserDto;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_user_to_database()
    {
        $userDto = new UserDto(
            name: '::name::',
            email: 'mail@mail.com',
            password: '::password::'
        );

        (new CreateUserAction)->run($userDto);

        $newUser = User::first();
        $this->assertEquals($newUser->name, $userDto->name);
        $this->assertEquals($newUser->email, $userDto->email);
    }
}
