<?php

declare(strict_types=1);

namespace App\Domains\Authentication\Models;

use App\Domains\Authentication\Database\Factories\UserFactory;
use App\Domains\Authentication\Models\Scopes\UserScopes;
use App\Support\Traits\HasUuid\HasUuidTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles {
        hasPermissionTo as hasPermissionToOriginal;
    }
    use HasUuidTrait;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use UserScopes;
    use CanResetPassword;

    public $guard_name = '*';

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'is_terminated'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_terminated' => 'boolean'
    ];

    protected $with = [
        'roles'
    ];

    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }

    protected function getDefaultGuardName(): string
    {
        return '*';
    }

    public function hasPermissionTo($permission, $guardName = '*'): bool
    {
        return $this->hasPermissionToOriginal($permission, $guardName);
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'user.' . $this->id;
    }
}
