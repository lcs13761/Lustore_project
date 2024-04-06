<?php

namespace App\Support\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasManyMixin
{
    public function syncMany(): Closure
    {
        return function (array $values) {
            /** @var HasMany $this */
            $result = $this->get();

            foreach ($result as $index => $data) {
                if (!empty($values[$index])) {
                    $data->update($values[$index]);
                    unset($values[$index]);
                } else {
                    $data->delete();
                }
            }

            $this->createMany($values);

            return $this->get();
        };
    }

}
