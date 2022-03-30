<?php

namespace Tests\Feature\Domains\Authentication\Dtos;

use App\Domains\Authentication\Dtos\UserDto;
use App\Domains\Authentication\Exceptions\UserDtoException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDtoTest extends TestCase
{
    public function test_it_should_throw_missing_attribute_exception_if_name_empty()
    {
        $this->expectException(UserDtoException::class);

        new UserDto('', '');
    }

    public function test_it_should_throw_missing_attribute_exception_if_email_empty()
    {
        $this->expectException(UserDtoException::class);

        new UserDto('::name::', '');
    }

    public function test_it_can_create_user_dto()
    {
        $userDto = $this->createUserDtoInstance(
            '::name::',
            '::email::',
            '::password::'
        );

        $this->assertEquals('::name::', $userDto->name);
        $this->assertEquals('::email::', $userDto->email);
        $this->assertEquals('::password::', $userDto->password);
    }

    public function test_it_can_convert_to_array_correctly()
    {
        $userDto = $this->createUserDtoInstance(
            '::name::',
            '::email::',
            '::password::'
        );

        $expected = [
            'name' => '::name::',
            'email' => '::email::',
            'password' => '::password::',
        ];

        $this->assertEquals($expected, $userDto->toArray(), 'mismatched array data of user dto');
    }

    public function test_it_should_omit_password_if_empty()
    {
        $userDto =  new UserDto('::name::', '::email::');
        $expected = [
            'name' => '::name::',
            'email' => '::email::',
        ];

        $this->assertEquals($expected, $userDto->toArray(), 'password not omitted from data');
    }

    private function createUserDtoInstance(string $name, string $email, string $password)
    {
        return new UserDto($name, $email, $password);
    }
}
