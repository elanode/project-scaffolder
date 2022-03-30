<?php

namespace Tests\Feature\Domains\Authentication\Actions;

use App\Domains\Authentication\Actions\AttemptLoginUserAction;
use App\Domains\Authentication\Exceptions\UserActionException;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AttemptLoginUserActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var AttemptLoginUserAction
     */
    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = new AttemptLoginUserAction;
    }

    public function test_it_should_return_true_if_credentials_is_true()
    {
        $password = '123123123';
        $user = $this->setUpUser($password);
        $actual = $this->action->run($user->email, $password);

        $this->assertTrue($actual, 'failed to attempt login');
    }

    public function test_it_should_throw_exception_if_invalid_password()
    {
        $user = $this->setUpUser();

        $this->expectException(UserActionException::class);
        $this->action->run($user->email, 'wrong password');
    }

    public function test_it_should_throw_exception_if_invalid_email()
    {
        $this->setUpUser();

        $this->expectException(UserActionException::class);
        $this->action->run('wrong email', '::password::');
    }

    private function setUpUser(string $password = '::password::'): User
    {
        $data = [
            'name' => '::name::',
            'email' => 'mail@mail.com',
            'password' => $password
        ];

        return User::create(array_merge($data, ['password' => Hash::make($data['password'])]));
    }
}
