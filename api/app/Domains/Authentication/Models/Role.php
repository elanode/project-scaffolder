<?php

namespace App\Domains\Authentication\Models;

class Role extends \Spatie\Permission\Models\Role
{
    protected $guard_name = '*';
}
