<?php

namespace Tests\Feature\Http\Middlewares;

use App\Domains\Authentication\Enums\RoleEnum;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class NotTerminatedUserMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seedDb();

        Route::get('terminated', function () {
            return true;
        })->middleware(['api', 'auth:api'])->prefix('api');
    }

    public function test_it_should_throw_exception_if_user_is_terminated()
    {
        $user = $this->setActingAs(RoleEnum::USER);
        $user->is_terminated = true;
        $user->save();

        $this->getJson('api/terminated')->assertStatus(403);
    }

    public function test_it_should_by_pass_if_superadmin()
    {
        $user = $this->setActingAs(RoleEnum::SUPERADMIN);
        $user->is_terminated = true;
        $user->save();

        $this->getJson('api/terminated')->assertStatus(200);
    }
}
