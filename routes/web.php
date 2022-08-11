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
Route::get('/countries', [Country::class, 'index'])->name('countries-index')->middleware('rp:admin') ;
//create
Route::get('/countries/create', [Country::class, 'create'])->name('countries-create')->middleware('rp:admin');
Route::post('/countries', [Country::class, 'store'])->name('countries-store')->middleware('rp:admin');
//edit
Route::get('/countries/edit/{country}', [Country::class, 'edit'])->name('countries-edit')->middleware('rp:admin');
Route::put('/countries/edit/{country}', [Country::class, 'update'])->name('countries-update')->middleware('rp:admin');
//delete
Route::delete('/countries/{country}', [Country::class, 'destroy'])->name('countries-delete')->middleware('rp:admin');

//Hotel routes
//index
Route::get('/hotels', [Hotel::class, 'index'])->name('hotels-index')->middleware('rp:user');
//create
Route::get('/hotels/create', [Hotel::class, 'create'])->name('hotels-create')->middleware('rp:admin');
Route::post('/hotels', [Hotel::class, 'store'])->name('hotels-store')->middleware('rp:admin');
//edit
Route::get('/hotels/edit/{hotel}', [Hotel::class, 'edit'])->name('hotels-edit')->middleware('rp:admin');
Route::put('/hotels/edit/{hotel}', [Hotel::class, 'update'])->name('hotels-update')->middleware('rp:admin');
//order
Route::put('/hotels/{hotel}', [Hotel::class, 'order'])->name('hotels-order')->middleware('rp:user');
//delete
Route::delete('/hotels/{hotel}', [Hotel::class, 'destroy'])->name('hotels-delete')->middleware('rp:admin');

//Order routes
//index
Route::get('/orders', [Order::class, 'index'])->name('orders-index')->middleware('rp:user');
//create
Route::get('/orders/create', [Order::class, 'create'])->name('orders-create')->middleware('rp:user');
Route::post('/orders', [Order::class, 'store'])->name('orders-store')->middleware('rp:user');
//edit
Route::get('/orders/edit/{order}', [Order::class, 'edit'])->name('orders-edit')->middleware('rp:user');
Route::put('/orders/edit/{order}', [Order::class, 'update'])->name('orders-update')->middleware('rp:user');
//delete
Route::delete('/orders/{order}', [Order::class, 'destroy'])->name('orders-delete')->middleware('rp:user');
// //order
// Route::put('/hotels/{hotel}', [Order::class, 'order'])->name('orders-add')->middleware('rp:user');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
