<?php

namespace App\Support\Mixins;

use Closure;

class HasManyMixin
{
    public function syncMany()
    {
        return function (array $values) {
            /** @var \Illuminate\Database\Eloquent\Relations\HasMan $this */
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
