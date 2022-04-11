<?php

namespace Tests\Feature\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\GetAllUserAction;
use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetAllUserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected string $testUrl;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed');
        $this->testUrl = '/api/authentication/users';
    }

    public function test_it_should_use_permission_middleware()
    {
        $this->assertRouteUsesMiddleware('authentication.users.index', ['permission:authentication get all user']);
    }

    public function test_it_can_be_accessed_by_admin()
    {
        $this->setActingAs(RoleEnum::ADMIN);

        $res = $this->getJson($this->testUrl);
        $res->assertStatus(200);
    }

    public function test_it_should_call_the_get_all_user_action()
    {
        $spy = $this->spy(GetAllUserAction::class)->makePartial();

        $this->setActingAs(RoleEnum::ADMIN);

        $res = $this->getJson($this->testUrl)
            ->assertStatus(200)
            ->assertJsonStructure($this->successResponseStructure);

        $spy->shouldHaveReceived('run');
    }
}
