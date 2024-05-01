<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\PenggunaController;

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

//AUTH
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/check-login', [AuthController::class, 'check_login'])->name('check-login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

// Akses
Route::get('/akses', [HakAksesController::class, 'akses'])->name('akses');

// Barang
Route::get('/barang', [BarangController::class, 'barang'])->name('barang');

// Pengguna
Route::get('/pengguna', [PenggunaController::class, 'pengguna'])->name('pengguna');
