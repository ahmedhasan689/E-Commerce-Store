<?php

use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'] );

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// Start Categories Controller ...
Route::get('/admin/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/admin/categories/create',[CategoriesController::class, 'create'])->name('categories.create');
Route::post('/admin/categories', [CategoriesController::class, 'store'])->name('categories.store');
Route::get('admin/categories/{id}', [CategoriesController::class, 'show'])->name('categories.show');
Route::get('/admin/categories/{id}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
Route::put('/admin/categories/{id}', [CategoriesController::class, 'update'])->name('categories.update');
Route::delete('/admin/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    // Resource Route For Categories Controller ...
    //Route::resource('/admin/categories', 'Admin\CategoriesController');
// End Categories Controller ...


// Start Product Controller ...
    // To SoftDeletes [ Trash, Restore, forceDelete Function ]
Route::get('/admin/products/trash', [ProductsController::class, 'trash'])->name('products.trash');
Route::put('/admin/products/trash/{id?}', [ProductsController::class, 'restore'])->name('products.restore');
Route::delete('/admin/products/trash/{id?}', [ProductsController::class, 'forceDelete'])->name('products.force-delete');
    // Here Is Basics functions In Resources File ( ProductsController )
Route::get('/admin/products', [ProductsController::class, 'index'])->middleware('auth')->name('products.index');
Route::get('/admin/products/create',[ProductsController::class, 'create'])->middleware('auth')->name('products.create');
Route::post('/admin/products', [ProductsController::class, 'store'])->middleware('auth')->name('products.store');
Route::get('admin/products/{id}', [ProductsController::class, 'show'])->middleware('auth')->name('products.show');
Route::get('/admin/products/{id}/edit', [ProductsController::class, 'edit'])->middleware('auth')->name('products.edit');
Route::put('/admin/products/{id}', [ProductsController::class, 'update'])->middleware('auth')->name('products.update');
Route::delete('/admin/products/{id}', [ProductsController::class, 'destroy'])->middleware(['auth'])->name('products.destroy');
// End Products Controller