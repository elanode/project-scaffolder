<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Models\Permission;
use App\Support\Actions\Enums\SortDirectionEnum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetAllPermissionsAction
{
    public function run(
        array $withs = [],
        string $orderColumn = 'created_at',
        SortDirectionEnum $sortDirection = SortDirectionEnum::DESC,
        int $paginate = 50,
    ): LengthAwarePaginator {
        return Permission::query()
            ->with($withs)
            ->orderBy($orderColumn, $sortDirection->value)
            ->paginate($paginate);
    }
}
