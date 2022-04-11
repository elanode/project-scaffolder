<?php

namespace Tests;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, AdditionalAssertions;

    protected array $successResponseStructure = [
        'data',
        'status',
        'message',
        'code',
        'others'
    ];

    protected function setActingAs(RoleEnum $roleEnum)
    {
        $user = User::role($roleEnum->value)->first();
        Passport::actingAs($user);
    }
}
