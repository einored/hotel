<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController as Country;
use App\Http\Controllers\HotelController as Hotel;
use App\Http\Controllers\OrderController as Order;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


//Country routes
//index
Route::get('/countries', [Country::class, 'index'])->name('countries-index');
//create
Route::get('/countries/create', [Country::class, 'create'])->name('countries-create');
Route::post('/countries', [Country::class, 'store'])->name('countries-store');
//edit
Route::get('/countries/edit/{country}', [Country::class, 'edit'])->name('countries-edit');
Route::put('/countries/edit/{country}', [Country::class, 'update'])->name('countries-update');
//delete
Route::delete('/countries/{country}', [Country::class, 'destroy'])->name('countries-delete');

//Hotel routes
//index
Route::get('/hotels', [Hotel::class, 'index'])->name('hotels-index');
//create
Route::get('/hotels/create', [Hotel::class, 'create'])->name('hotels-create');
Route::post('/hotels', [Hotel::class, 'store'])->name('hotels-store');
//edit
Route::get('/hotels/edit/{hotel}', [Hotel::class, 'edit'])->name('hotels-edit');
Route::put('/hotels/edit/{hotel}', [Hotel::class, 'update'])->name('hotels-update');
//delete
Route::delete('/hotels/{hotel}', [Hotel::class, 'destroy'])->name('hotels-delete');

//Order routes
//index
Route::get('/orders', [Order::class, 'index'])->name('orders-index');
//create
Route::get('/orders/create', [Order::class, 'create'])->name('orders-create');
Route::post('/orders', [Order::class, 'store'])->name('orders-store');
//edit
Route::get('/orders/edit/{order}', [Order::class, 'edit'])->name('orders-edit');
Route::put('/orders/edit/{order}', [Order::class, 'update'])->name('orders-update');
//delete
Route::delete('/orders/{order}', [Order::class, 'destroy'])->name('orders-delete');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
