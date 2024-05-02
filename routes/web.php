<?php

use App\Http\Controllers\AccesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
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
Route::get('/acces', [AccesController::class, 'acces'])->name('acces');
Route::post('acces/add_acces', [AccesController::class, 'add_acces'])->name('acces/add_acces');
Route::post('acces/edit_acces', [AccesController::class, 'edit_acces'])->name('acces/edit_acces');
Route::post('acces/delete_acces', [AccesController::class, 'delete_acces'])->name('acces/delete_acces');

Route::get('/get_id_acces/{id}', [AccesController::class, 'get_id_acces'])->name('get_id_acces/{id}');

// Barang
Route::get('/barang', [BarangController::class, 'barang'])->name('barang');

// Pengguna
Route::get('/pengguna', [PenggunaController::class, 'pengguna'])->name('pengguna');
