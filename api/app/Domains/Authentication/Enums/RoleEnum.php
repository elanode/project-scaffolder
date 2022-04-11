<?php

namespace App\Domains\Authentication\Enums;

enum RoleEnum: string
{
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';
    case USER = 'user';
}
