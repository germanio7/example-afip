<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ultimo-comprobante', [\App\Http\Controllers\AfipController::class, 'lastVoucher'])->name('ultimo.comprobante');
Route::get('/ver-comprobante', [\App\Http\Controllers\AfipController::class, 'getVoucher'])->name('ver.comprobante');
Route::get('/crear-comprobante', [\App\Http\Controllers\AfipController::class, 'createVoucher'])->name('crear.comprobante');
