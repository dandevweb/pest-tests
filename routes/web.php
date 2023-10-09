<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/403', function () {
    return abort(403);
});

Route::get('/500', function () {
    return abort(500);
});


Route::get('/products', function () {
    return view('products', [
        'products' => Product::all(),
    ]);
})->name('products');

Route::post('/products', function () {
    Product::create([
        'title' => request()->title,
    ]);


    return response()->json('', 201);
})->name('products.store');
