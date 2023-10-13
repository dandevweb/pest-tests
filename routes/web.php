<?php

use App\Actions\CreateProductAction;
use App\Models\User;
use App\Models\Product;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\ImportProductsJob;
use App\Notifications\NewProductNotification;
use Illuminate\Support\Facades\Route;

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

Route::post('/products', function (Request $request) {

    $request->validate([
        'title' => 'required|max:255',
    ]);

    app(CreateProductAction::class)
        ->handle($request->title, auth()->user());

    return response()->json('', 201);
})->name('products.store');

Route::put('/products/{product}', function (Product $product) {
    $product->update([
        'title' => request()->title,
    ]);

    return response()->json('', 200);
})->name('products.update');

Route::delete('/products/{product}', function (Product $product) {
    $product->forceDelete();

    return response()->json('', 200);
})->name('products.destroy');

Route::delete('/products/{product}/soft-delete', function (Product $product) {
    $product->delete();

    return response()->json('', 200);
})->name('products.soft-delete');

Route::post('/sending-email/{user}', function (User $user) {
    Mail::to($user)->send(new WelcomeEmail($user));
})->name('sending-email');

Route::post('/products/import', function () {
    $data = request()->get('data');

    ImportProductsJob::dispatch($data, auth()->id());

    return response()->json('', 200);
})->name('products.import');
