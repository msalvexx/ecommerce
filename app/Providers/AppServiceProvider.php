<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Traits\HasCategoryFilter;
use App\Traits\HasFilter;
use App\Traits\IsSortable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        HasCategoryFilter::categoryResolver(function () {
            return $this->app['request']->query('q');
        });

        HasFilter::filterResolver(function () {
            return $this->app['request']->query('filter');
        });

        IsSortable::sortResolver(function () {
            return $this->app['request']->query('sort');
        });
    }
}
