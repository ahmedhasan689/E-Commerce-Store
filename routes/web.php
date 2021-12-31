<?php

use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProfilesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RatingsController;
use App\Http\Middleware\CheckUserType;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::namespace('Admin')
    ->prefix('admin')
    ->middleware(['admin', 'auth.type:user'])
    ->group(function () {

        // Start Categories Controller ...
        Route::group([
            'prefix' => '/categories',
            'as' => 'categories.' // Like name ('categories.index/delete')
        ], function () {
            Route::get('/', [CategoriesController::class, 'index'])->name('index');
            Route::get('/create', [CategoriesController::class, 'create'])->name('create')->middleware(['can:categories.create']);
            Route::post('/', [CategoriesController::class, 'store'])->name('store');
            Route::get('/{category}', [CategoriesController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [CategoriesController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CategoriesController::class, 'update'])->name('update');
            Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('destroy');
            // Resource Route For Categories Controller ...
            //Route::resource('/admin/categories', 'Admin\CategoriesController');
        });
        // End Categories Controller ...

        // Start Product Controller ...
        Route::group([
            'prefix' => 'products',
            'as' => 'products.'
        ], function () {
            // To SoftDeletes [ Trash, Restore, forceDelete Function ]
            Route::get('/trash', [ProductsController::class, 'trash'])->name('trash');
            Route::put('/trash/{id?}', [ProductsController::class, 'restore'])->name('restore');
            Route::delete('/trash/{id?}', [ProductsController::class, 'forceDelete'])->name('force-delete');
            // Here Is Basics functions In Resources File ( ProductsController )
            Route::get('/', [ProductsController::class, 'index'])->name('index');
            Route::get('/create', [ProductsController::class, 'create'])->name('create');
            Route::post('/', [ProductsController::class, 'store'])->name('store');
            Route::get('/{id}', [ProductsController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ProductsController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProductsController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductsController::class, 'destroy'])->name('destroy');
        });
        // End Products Controller

        // Start Role Controller ...
        Route::resource('/roles', 'Admin\RolesController')->middleware(['auth']);
        // End Role Controller

        // Get User 
        Route::get('/get-user', [HomeController::class, 'getUser']);

        // Start Country Route
        Route::resource('/countries', 'Admin\CountriesController');
        // End Country Route

        // Start Profile Route
        Route::get('/profiles/{profiles}', [ProfilesController::class, 'show']);
        // End Profile Route

    });

Route::get('products', 'ProductsController@index')->name('products');
Route::get('products/{slug}', 'ProductsController@show')->name('products.details');


// Start Rating Route (Rating Model)  
Route::post('ratings/{type}', [RatingsController::class, 'store'])->where('type', 'profile|product');

// Start Cart Route ( CartController )
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'store']);