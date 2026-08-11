<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PengulanganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemPenjualanController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware('role:admin,kasir')->group(function () {
        Route::resource('/produk', ProdukController::class);
        Route::resource('/penjualan', PenjualanController::class);
        Route::resource('/itempenjualan', ItemPenjualanController::class);
        Route::resource('/pengulangan', PengulanganController::class);
        // Tambahkan route POST khusus ini:
        Route::post('/pengulangan/proses', [PengulanganController::class, 'proses'])->name('pengulangan.proses');
        });
    });