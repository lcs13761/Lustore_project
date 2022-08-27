<?php

namespace App\Providers;

use App\Support\Mixins;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mixins();
    }

    protected function mixins()
    {
        HasMany::mixin(new Mixins\HasManyMixin());
        Collection::mixin(new Mixins\CollectionMixin());
        Response::mixin(new Mixins\ResponseMixin());
    }
}
