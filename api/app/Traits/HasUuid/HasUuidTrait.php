<?php

namespace App\Traits\HasUuid;

use Illuminate\Support\Str;

trait HasUuidTrait
{
    public static function bootHasUuidTrait(): void
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
