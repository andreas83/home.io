<?php

namespace App\Providers;
use CloudCreativity\LaravelJsonApi\LaravelJsonApi;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        LaravelJsonApi::defaultApi('v1');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
