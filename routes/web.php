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
use App\Http\Controllers\Admin\PickupTruckController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\User\UserDashController;
use App\Http\Controllers\User\TransaksiSampahController as UserTransaksiController;
use App\Http\Controllers\Petugas\PetugasDashController;
use App\Http\Controllers\Petugas\PenjemputanController;


// AUTH ADMIN
Route::get('/', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/logout-admin', [AdminLoginController::class, 'logout'])->name('admin.logout');


// ADMIN AREA
Route::middleware(['auth:admin','role:admin'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

        // Admin profile
        Route::get('/profile', [AdminController::class, 'profile'])
            ->name('profile');

        // CRUD Resources
        Route::resource('users', UserController::class);
        Route::resource('petugas', PetugasController::class);
        Route::resource('kategori', KategoriSampahController::class);
        Route::resource('trucks', PickupTruckController::class);

        // Teams, Batches
        Route::resource('teams', TeamController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('batches', BatchController::class)->only(['index', 'create', 'store']);
        Route::post('/batches/{id_batch}/assign-team', [BatchController::class, 'assignTeam'])
            ->name('batches.assignTeam');
        Route::post('/batches/{id_batch}/cancel', [BatchController::class, 'cancel'])
            ->name('batches.cancel');
        Route::post('/batches/{id_batch}/start', [BatchController::class, 'start'])
            ->name('batches.start');
        Route::post('/batches/{id_batch}/selesai', [BatchController::class, 'selesai'])
            ->name('batches.selesai');
        Route::get('/batches/{id_batch}/transaksi', [BatchController::class, 'transaksi'])
            ->name('batches.transaksi');

        // Transaksi listing and edit/update; plus batch operations
        Route::resource('transaksi', TransaksiSampahController::class)->only(['index', 'edit', 'update']);
        Route::post('/transaksi/{id}/assign-batch', [TransaksiSampahController::class, 'assignBatch'])
            ->name('transaksi.assignBatch');
        Route::post('/transaksi/{id}/remove-batch', [TransaksiSampahController::class, 'removeBatch'])
            ->name('transaksi.removeBatch');

        // Laporan (Reports)
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

});


// AUTH USER
Route::get('/user', [UserLoginController::class, 'showLoginForm'])->name('user.login');
Route::post('/user', [UserLoginController::class, 'login'])->name('user.login.submit');
Route::post('/logout-user', [UserLoginController::class, 'logout'])->name('user.logout');


// USER AREA (protected)
Route::middleware(['auth:web','role:user'])->group(function () {

    Route::prefix('user')->name('user.')->group(function () {

        Route::get('/dashboard', [UserDashController::class, 'index'])->name('dashboard');




        Route::resource('transaksi', UserTransaksiController::class)
            ->only(['index', 'create', 'store']);

    });
});


// AUTH PETUGAS
Route::get('/petugas', [PetugasLoginController::class, 'showLoginForm'])->name('petugas.login');
Route::post('/petugas', [PetugasLoginController::class, 'login'])->name('petugas.login.submit');
Route::post('/logout-petugas', [PetugasLoginController::class, 'logout'])->name('petugas.logout');

// PETUGAS AREA
Route::middleware('auth:petugas')->prefix('petugas')->name('petugas.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [PetugasDashController::class, 'index'])
            ->name('dashboard');

        // Penjemputan daftar dan aksi
        Route::get('/penjemputan', [PenjemputanController::class, 'index'])
            ->name('penjemputan.index');
        Route::post('/penjemputan/{id}/berat', [PenjemputanController::class, 'updateBerat'])
            ->name('penjemputan.updateBerat');
        Route::post('/penjemputan/{id}/selesai', [PenjemputanController::class, 'selesaikan'])
            ->name('penjemputan.selesaikan');
});
