<?php

namespace Tests\Feature\Domains\Authentication\Actions;

use App\Domains\Authentication\Actions\GetCurrentUserAction;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class GetCurrentUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_return_authenticated_user()
    {
        /** @var User */
        $user = User::factory()->create();
        $request = (new Request)
            ->merge(['user' => $user])
            ->setUserResolver(fn () => $user);
        $this->actingAs($user);

        $actual = (new GetCurrentUserAction)->run($request);

        $this->assertEquals($user->name, $actual->name, 'wrong user returned');
    }

    public function test_it_should_return_null_if_no_user_instance_in_the_request()
    {
        $actual = (new GetCurrentUserAction)->run(new Request());

        $this->assertTrue($actual === null);
    }
}
