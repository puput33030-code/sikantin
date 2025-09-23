<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('pages.order.index');
// });
Route::get('/', [App\Http\Controllers\OrderController::class, 'index'])->name('order.index');

// Tambahkan menu ke keranjang (session)
Route::post('/order/add/{menu}', [App\Http\Controllers\OrderController::class, 'addToCart'])->name('order.add');

// Tampilkan keranjang
Route::get('/cart', [App\Http\Controllers\OrderController::class, 'cart'])->name('order.cart');

// Hapus keranjang 
Route::delete('/cart/delete/{id}', [App\Http\Controllers\OrderController::class, 'removeFromCart'])->name('cart.delete');

// Tampilkan halaman checkout (isi keranjang + form data diri)
Route::get('/checkout/{id}', [App\Http\Controllers\OrderController::class, 'checkout'])->name('order.checkout');

Route::post('/cart/save-customer', [App\Http\Controllers\OrderController::class, 'saveCustomerInfo'])->name('order.saveCustomer');
Route::get('/confirmation', [App\Http\Controllers\OrderController::class, 'confirmation'])->name('order.confirmation');
Route::post('/place-order', [App\Http\Controllers\OrderController::class, 'placeOrder'])->name('order.placeOrder');


// Proses checkout (simpan ke tabel orders & order_items)
Route::post('/checkout', [App\Http\Controllers\OrderController::class, 'processCheckout'])->name('order.process');


Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
    'confirm'=> false
]);

Route::group([
    'middleware' => ['auth']
    //Auth middleware : untuk mengecek apakah user sudah login
], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); 
    
    Route::resource('/kasir', App\Http\Controllers\KasirController::class)->except(['edit', 'update']);

    Route::get('/ubah-profil', [App\Http\Controllers\ProfilController::class, 'index'])->name('ubah-profil');
    Route::get('/ubah-profil/edit', [App\Http\Controllers\ProfilController::class, 'edit'])->name('ubah-profil.edit');
    Route::post('/ubah-profil', [App\Http\Controllers\ProfilController::class, 'update'])->name('ubah-profil.update');

    Route::resource('/menu', App\Http\Controllers\MenuController::class);

    Route::resource('/kategori', App\Http\Controllers\CategoryController::class)->except(['show']);
});
