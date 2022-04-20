<?php

namespace App\Domains\Authentication\Tests\Actions;

use App\Domains\Authentication\Actions\GetUserAction;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserActionTest extends TestCase
{
    use RefreshDatabase;

    /** @var GetUserAction */
    protected $getUserAction;

    public function setUp(): void
    {
        parent::setUp();

        $this->seedDb();
        $this->getUserAction = app(GetUserAction::class);
    }

    public function test_it_should_return_user()
    {
        $user = $this->getUserAction->run(1);

        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->id === 1);
    }

    public function test_it_should_load_relations()
    {
        $user = $this->getUserAction->run(1, ['permissions']);

        $this->assertTrue($user->relationLoaded('permissions'));
    }
}
