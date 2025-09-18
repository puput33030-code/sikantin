<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
