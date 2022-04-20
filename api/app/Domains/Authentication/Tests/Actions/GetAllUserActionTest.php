<?php

namespace Tests\Feature\Domains\Authentication\Actions;

use App\Domains\Authentication\Actions\GetAllUserAction;
use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class GetAllUserActionTest extends TestCase
{
    use RefreshDatabase;

    /** @var GetAllUserAction */
    protected $gettAllUserAction;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed');
        $this->gettAllUserAction = app(GetAllUserAction::class);
    }

    public function test_it_should_return_user_collection()
    {
        $expected = User::role([RoleEnum::ADMIN->value, RoleEnum::USER->value])->count();
        $users = $this->gettAllUserAction->run();

        $this->assertEquals($expected, $users->total());
    }

    public function test_it_should_return_all_user_collection_if_superadmin_true()
    {
        $expected = User::count();
        $users = $this->gettAllUserAction->run(notSuperadmin: false);

        $this->assertEquals($expected, $users->total());
    }

    public function test_it_should_load_roles_relation_by_default()
    {
        $users = $this->gettAllUserAction->run();

        /** @var User */
        $firstUser = $users[0];

        $this->assertTrue($firstUser->relationLoaded('roles'));
    }
}
