<?php

use App\Http\Controllers\AccesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TransactionController;

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

// Acces
Route::get('/acces', [AccesController::class, 'acces'])->name('acces');
Route::post('acces/add_acces', [AccesController::class, 'add_acces'])->name('acces/add_acces');
Route::post('acces/edit_acces', [AccesController::class, 'edit_acces'])->name('acces/edit_acces');
Route::post('acces/delete_acces', [AccesController::class, 'delete_acces'])->name('acces/delete_acces');
Route::get('/get_id_acces/{id}', [AccesController::class, 'get_id_acces'])->name('get_id_acces/{id}');

// Item
Route::get('/item', [ItemController::class, 'item'])->name('item');
Route::post('item/add_item', [ItemController::class, 'add_item'])->name('item/add_item');
Route::post('item/edit_item', [ItemController::class, 'edit_item'])->name('item/edit_item');
Route::post('item/delete_item', [ItemController::class, 'delete_item'])->name('item/delete_item');
Route::get('/get_id_item/{id}', [ItemController::class, 'get_id_item'])->name('get_id_item/{id}');

// Pengguna
Route::get('/pengguna', [PenggunaController::class, 'pengguna'])->name('pengguna');


// Transaction
Route::get('/transaction', [TransactionController::class, 'transaction'])->name('transaction');
Route::get('detail-by-transaction/{id}', [TransactionController::class, 'detail_trans_by_id'])->name('detail-by-transaction/{id}');
Route::get('page-add-transaction', [TransactionController::class, 'page_add_transaction'])->name('page-add-transaction');
Route::get('/get-item/{id}', [TransactionController::class, 'get_item'])->name('get-item/{id}');
Route::post('trans/add', [TransactionController::class, 'add_trans'])->name('trans/add');


// Transaction Detail
Route::post('transaction/add', [TransactionController::class, 'add_transaction'])->name('transaction/add');
Route::post('transaction/delete/{id}', [TransactionController::class, 'delete_transaction_detail'])->name('transaction/delete/{id}');
