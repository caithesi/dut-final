<?php

namespace App\Providers;

use App\Models\Product;
use App\Observers\ProductObserver;
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
        ViewFactory::macro('shopper', function ($name, $data = []) {
            return View::make('shopper', ['name' => $name, 'data' => $data]);
        });
        Product::observe(ProductObserver::class);
    }
}
