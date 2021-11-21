<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\View\Factory as ViewFactory;

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
        ViewFactory::macro('component', function ($name, $data = []) {
            return View::make('welcome', ['name' => $name, 'data' => $data]);
        });
    }
}
