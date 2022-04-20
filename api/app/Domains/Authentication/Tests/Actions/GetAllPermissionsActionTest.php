<?php

namespace App\Domains\Authentication\Tests\Actions;

use App\Domains\Authentication\Actions\GetAllPermissionsAction;
use App\Domains\Authentication\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAllPermissionsActionTest extends TestCase
{
    use RefreshDatabase;

    /** @var GetAllPermissionsAction */
    protected $getAllPermissionsAction;

    public function setUp(): void
    {
        parent::setUp();

        $this->seedDb();
        $this->getAllPermissionsAction = app(GetAllPermissionsAction::class);
    }

    public function test_it_should_return_all_permissions()
    {
        $expected = Permission::count();
        $permissions = $this->getAllPermissionsAction->run();

        $this->assertEquals($expected, $permissions->total());
    }

    public function test_it_should_paginate_if_provided()
    {
        $permissions  = $this->getAllPermissionsAction->run(paginate: 2);
        $this->assertTrue($permissions->perPage() == 2);
    }
}
