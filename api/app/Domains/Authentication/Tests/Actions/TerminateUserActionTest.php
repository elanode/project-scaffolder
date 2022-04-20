<?php

namespace App\Domains\Authentication\Tests\Actions;

use App\Domains\Authentication\Actions\TerminateUserAction;
use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Exceptions\AuthenticationDomainException;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TerminateUserActionTest extends TestCase
{
    use RefreshDatabase;

    /** @var TerminateUserAction */
    protected $terminateUserAction;

    public function setUp(): void
    {
        parent::setUp();
        $this->seedDb();
        $this->terminateUserAction = new TerminateUserAction;
    }

    public function test_it_can_terminate_user()
    {
        $this->terminateUserAction->run([2, 3]);
        $this->assertTrue(User::find(2)->is_terminated);
        $this->assertTrue(User::find(3)->is_terminated);
    }

    public function test_it_can_not_terminate_superadmins()
    {
        $this->expectException(AuthenticationDomainException::class);
        $this->expectExceptionMessage('Cannot terminate superadmin');
        $this->terminateUserAction->run([User::role(RoleEnum::SUPERADMIN->value)->first()->id]);
    }
}
