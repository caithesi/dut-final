<?php

use App\Http\Controllers\Admin\{
    AdminController,
    AdminUserController,
    CategoryController,
    MenuController,
    ProductController,
    SettingController,
    SliderController,
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

Route::get('/test', [Test::class, 'show']);

Route::get('/login', [AdminController::class, 'loginAdmin'])->name('login');
Route::post('/login', [AdminController::class, 'postLoginAdmin']);

Route::get('/', [AdminController::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resources([
        'menu' => MenuController::class,
        'category' =>  CategoryController::class,
        'product' => ProductController::class,
        'slider' => SliderController::class,
        'setting' => SettingController::class,
        'user' => AdminUserController::class,
    ]);
});




Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
