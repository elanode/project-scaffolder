<?php

namespace App\Domains\Authentication\Models\Scopes;

use App\Domains\Authentication\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Builder;

trait UserScopes
{
    public function scopeWithoutSuperAdmins(Builder $query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', RoleEnum::SUPERADMIN->value);
        });
    }
}
