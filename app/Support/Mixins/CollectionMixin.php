<?php

namespace App\Support\Mixins;

use Illuminate\Support\Str;

class CollectionMixin
{
    public function exceptCollection()
    {
        return function ($except) {
            /** @var \Illuminate\Support\Collection $this */
            return $this->map(fn ($data) => collect($data)->except($except)->all());
        };
    }
}
