<?php

namespace Tests\Feature\Domains\Authentication\Factories;

use App\Domains\Authentication\Dtos\UserDto;
use App\Domains\Authentication\Factories\UserDataFactory;
use App\Domains\Authentication\Http\Requests\UserFormRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class UserDataFactoryTest extends TestCase
{
    public function test_it_can_create_user_dto_from_array()
    {
        $data = [
            'name' => '::name::',
            'email' => '::email::',
            'password' => '::password::'
        ];

        $userDto = UserDataFactory::fromArray($data);

        $this->assertInstanceOf(UserDto::class, $userDto);
        $this->assertTrue($userDto->name === '::name::');
        $this->assertTrue($userDto->email === '::email::');
        $this->assertTrue($userDto->password === '::password::');
    }

    public function test_it_can_create_user_dto_from_array_with_password_missing()
    {
        $data = [
            'name' => '::name::',
            'email' => '::email::',
        ];

        $userDto = UserDataFactory::fromArray($data);

        $this->assertInstanceOf(UserDto::class, $userDto);
        $this->assertTrue($userDto->name === '::name::');
        $this->assertTrue($userDto->email === '::email::');
        $this->assertTrue($userDto->password === null);
    }

    public function test_it_can_create_user_dto_from_form_request()
    {
        $userDto = UserDataFactory::fromRequest($this->mockUserFormRequest());

        $this->assertTrue($userDto->name === '::name::');
        $this->assertTrue($userDto->email === '::email::');
        $this->assertTrue($userDto->password === '::password::');
    }

    public function test_it_should_leave_password_to_null_if_request_not_giving_password()
    {
        $userDto = UserDataFactory::fromRequest($this->mockUserFormRequest(false));

        $this->assertTrue($userDto->name === '::name::');
        $this->assertTrue($userDto->email === '::email::');
        $this->assertTrue($userDto->password === null);
    }

    private function mockUserFormRequest(bool $withPassword = true): UserFormRequest
    {
        /** @var UserFormRequest */
        $mockFormRequest = $this->mock(
            UserFormRequest::class,
            function (MockInterface $mock) use ($withPassword) {
                $data = [
                    'name' => '::name::',
                    'email' => '::email::',
                ];

                if ($withPassword) {
                    $data = array_merge($data, [
                        'password' => '::password::',
                    ]);
                }

                $mock->shouldReceive('validated')->andReturn($data);
            }
        );

        return $mockFormRequest;
    }
}
