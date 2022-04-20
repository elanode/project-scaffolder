<?php

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseJsonResource extends JsonResource
{
    public function loadOrNull(string $relationName, string $resourceClass, bool $collection = false)
    {
        $loaded =  $this->relationLoaded($relationName);
        if (!$loaded) {
            return null;
        }

        return $collection ?
            $resourceClass::collection($this->{$relationName}) :
            new $resourceClass($this->{$relationName});
    }
}
