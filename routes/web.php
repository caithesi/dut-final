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
    DeliveryController,
    HomeController,
    OrderController,
    ShopperCategoryController,
    ShopperProductController,
    ReccomnedController,
};
use App\Http\Controllers\Test;
use App\Http\Controllers\UserController;
use App\Models\Role;
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
Route::prefix('shop')->name('shop.')->group(function () {
    Route::post('/products/{id}/cart', [ShopperProductController::class, 'addToCart'])->name('products.cart');
    Route::get('/products/cart', [ShopperProductController::class, 'cartShow'])->name('products.cart-show');
    Route::post('/products/{id}/rating', [ShopperProductController::class, 'rating'])->name('products.rating')->middleware('auth');
    Route::resource('product', ShopperProductController::class);
});
Route::get('logged/user', [UserController::class, 'getLoginedUser'])->name('logged.user');
Route::get('/test', [Test::class, 'show']);
Route::post('/checkout', [OrderController::class, 'checkOut'])->middleware('auth')->name('shop.check-out');
Route::get('/login', [AdminController::class, 'loginAdmin'])->name('login');
Route::post('/login', [AdminController::class, 'postLoginAdmin']);
Route::prefix('delivery')->name('delivery.')->group(function () {
    Route::get('/', [DeliveryController::class, 'shipping']);
    Route::get('/province', [DeliveryController::class, 'getProvince'])->name('address.province');
    Route::get('/province/{provine_id}/district', [DeliveryController::class, 'getDistrict'])->name('address.district');
    Route::get('/district/{district_id}/ward', [DeliveryController::class, 'getWard'])->name('address.ward');
    Route::get('/fee/{district_id}/{ward_code}/{service_id}', [DeliveryController::class, 'getFee'])->name('fee');
    Route::get('{district_id}/available-service/', [DeliveryController::class, 'getAvailableService'])->name('available-service');
});

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
