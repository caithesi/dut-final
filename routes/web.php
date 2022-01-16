<?php

use App\Http\Controllers\Admin\{
    AdminController,
    AdminUserController,
    CategoryController,
    MenuController,
    ProductController,
    RoleController,
    SettingController,
    SliderController,
};
use App\Http\Controllers\Shopper\{
    HomeController,
    ShopperCategoryController,
};
use App\Http\Controllers\Test;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('shopper-home');
Route::get('home-category', [HomeController::class, 'categories']);
Route::get('/page-config/{config_key}', [HomeController::class, 'getConfig']);
Route::get('/category/{slug}/{id}', [ShopperCategoryController::class, 'index'])->name('shopper.category');
Route::get('/test', [Test::class, 'show']);

Route::get('/login', [AdminController::class, 'loginAdmin'])->name('login');
Route::post('/login', [AdminController::class, 'postLoginAdmin']);


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware('auth')->name('dashboard');

    Route::resources([
        'menu' => MenuController::class,
        'category' =>  CategoryController::class,
        'product' => ProductController::class,
        'slider' => SliderController::class,
        'setting' => SettingController::class,
        'user' => AdminUserController::class,
        'role' => RoleController::class,
    ]);
});




Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
