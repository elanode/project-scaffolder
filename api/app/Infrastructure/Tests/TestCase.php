<?php

namespace Tests;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, AdditionalAssertions;

    protected string $testUrl;

    protected array $successResponseStructure = [
        'data',
        'status',
        'message',
        'code',
        'others'
    ];

    protected function setActingAs(RoleEnum $roleEnum): User
    {
        $user = User::role($roleEnum->value)->first();
        Passport::actingAs($user);

        return $user;
    }

    protected function seedDb()
    {
        Artisan::call('db:seed');
    }
}
