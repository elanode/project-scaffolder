<?php

namespace App\Domains\Authentication\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $guard_name = '*';
}
