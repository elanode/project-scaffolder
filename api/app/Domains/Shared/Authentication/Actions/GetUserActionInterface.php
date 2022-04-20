<?php

namespace App\Domains\Shared\Authentication\Actions;

use Illuminate\Database\Eloquent\Model;

interface GetUserActionInterface
{
    public function run(
        int $userId,
        array $withs = []
    ): Model;
}
