<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\PetugasLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\KategoriSampahController;
use App\Http\Controllers\Admin\TransaksiSampahController;
use App\Http\Controllers\User\UserDashController;
use App\Http\Controllers\User\UserTransaksiController;



// AUTH ADMIN
Route::get('/', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/logout-admin', [AdminLoginController::class, 'logout'])->name('admin.logout');


// ADMIN AREA (protected)
Route::middleware('auth:admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::resource('users', UserController::class);
        Route::resource('petugas', PetugasController::class);
        Route::resource('kategori', KategoriSampahController::class);
        Route::resource('transaksi', TransaksiSampahController::class);

        Route::post('/transaksi/{id}/assign', [TransaksiSampahController::class, 'assign'])
            ->name('transaksi.assign');

        Route::post('/transaksi/{id}/selesai', [TransaksiSampahController::class, 'selesai'])
            ->name('transaksi.selesai');
    });

});


// AUTH USER
Route::get('/user', [UserLoginController::class, 'showLoginForm'])->name('user.login');
Route::post('/user', [UserLoginController::class, 'login'])->name('user.login.submit');
Route::post('/logout-user', [UserLoginController::class, 'logout'])->name('user.logout');


// USER AREA (protected)
Route::middleware('auth:web')->group(function () {

    Route::prefix('user')->name('user.')->group(function () {

        Route::get('/dashboard', [UserDashController::class, 'index'])->name('dashboard');

        Route::resource('transaksi', UserTransaksiController::class)
            ->only(['index', 'create', 'store', 'show']);
    });
});


// AUTH PETUGAS
Route::get('/petugas', [PetugasLoginController::class, 'showLoginForm'])->name('petugas.login');
Route::post('/petugas', [PetugasLoginController::class, 'login'])->name('petugas.login.submit');
Route::post('/logout-petugas', [PetugasLoginController::class, 'logout'])->name('petugas.logout');
