<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Models\User;
use App\Support\Actions\Enums\SortDirectionEnum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllUserAction
{
    public function run(
        array $withs = ['roles'],
        string $orderColumn = 'created_at',
        SortDirectionEnum $sortDirection = SortDirectionEnum::DESC,
        int $paginate = 50
    ): LengthAwarePaginator {
        return User::query()
            ->with($withs)
            ->orderBy($orderColumn, $sortDirection->value)
            ->paginate($paginate);
    }
}
