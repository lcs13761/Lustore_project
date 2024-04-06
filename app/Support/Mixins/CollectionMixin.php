<?php

namespace App\Support\Mixins;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CollectionMixin
{
    public function exceptCollection(): \Closure
    {
        return function ($except) {
            /** @var Collection $this */
            return $this->map(fn ($data) => collect($data)->except($except)->all());
        };
    }
}
