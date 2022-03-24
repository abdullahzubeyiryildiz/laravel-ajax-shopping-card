<?php

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
use App\Http\Controllers\ShoppingController;


Route::controller(ShoppingController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('cart', 'cart')->name('cart');
    Route::post('add-to-cart', 'addToCart')->name('add.to.cart');
    Route::patch('update-cart', 'update')->name('update.cart');
    Route::delete('remove-from-cart', 'remove')->name('remove.from.cart');
    Route::delete('remove.all.cart', 'destroy')->name('remove.all.cart');
});


//Route::get('/', [ProductController::class, 'index']);
