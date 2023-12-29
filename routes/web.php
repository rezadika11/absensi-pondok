<?php

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
    return view('admin.master');
});

Route::get('/beranda', [App\Http\Controllers\berandaController::class, 'pondok']);

Route::post('/logout',[App\Http\Controllers\loginController::class,'logout'])->name('logout');

Route::get('/login', [App\Http\Controllers\loginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\loginController::class, 'login'])->name('login.store');

Route::get('/register', [App\Http\Controllers\registerController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\registerController::class,'store'])->name('register.store');
