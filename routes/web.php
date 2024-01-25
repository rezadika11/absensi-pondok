<?php

use App\Http\Controllers\Admin\SantriController;
use App\Http\Controllers\Admin\KitabController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes([
  'register' => false,
  'reset' => false,
]);

Route::get('/', [DashboardController::class, 'sessionLogin'])->name('sessionLogin');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
  Route::controller(SantriController::class)->group(function () {
    Route::get('/santri/data', 'dataSantri')->name('dataSantri');
    Route::get('/santri', 'santri')->name('santri');
    Route::get('/santri/tambah', 'tambahSantri')->name('tambahSantri');
    Route::post('/santri', 'simpanSantri')->name('simpanSantri');
    Route::get('/santri/edit/{id}', 'editSantri')->name('editSantri');
    Route::post('/santri/edit/{id}', 'updateSantri')->name('updateSantri');
    Route::delete('/santri/hapus/{id}', 'hapusSantri')->name('hapusSantri');
  });
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
  Route::controller(KitabController::class)->group(function () {
    Route::get('/kitab/toko', 'tokoKitab')->name('tokoKitab');
    Route::get('/kitab', 'kitab')->name('kitab');
    Route::get('/kitab/tambah', 'tambahKitab')->name('tambahKitab');
    Route::post('/kitab', 'simpankitab')->name('simpanKitab');
    Route::get('/kitab/edit/{id}', 'editKitab')->name('editiKitab');
    Route::post('/kitab/edit/{id}', 'updateKitab')->name('updateKitab');
    Route::delete('/kitab/hapus/{id}', 'hapusKitab')->name('hapusKitab');
  });
});


