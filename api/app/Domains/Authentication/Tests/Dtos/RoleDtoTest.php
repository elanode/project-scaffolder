<?php

namespace Tests\Feature\Domains\Authentication\Dtos;

use App\Domains\Authentication\Dtos\RoleDto;
use App\Domains\Authentication\Exceptions\RoleDtoException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleDtoTest extends TestCase
{
    public function test_it_should_throw_error_if_name_is_empty()
    {
        $this->expectException(RoleDtoException::class);

        new RoleDto('');
    }

    public function test_it_should_create_new_role_dto()
    {
        $dto = new RoleDto('name');

        $this->assertEquals($dto->name, 'name');
    }
}
