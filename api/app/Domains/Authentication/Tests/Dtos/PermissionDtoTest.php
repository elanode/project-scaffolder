<?php

namespace Tests\Feature\Domains\Authentication\Dtos;

use App\Domains\Authentication\Dtos\PermissionDto;
use App\Domains\Authentication\Exceptions\PermissionDtoException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PermissionDtoTest extends TestCase
{
    public function test_it_should_throw_if_role_id_is_not_numeric()
    {
        $this->expectException(PermissionDtoException::class);
        new PermissionDto(':testing:', ["hello"]);
    }
}
