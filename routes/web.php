<?php
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\ListPembelianController;

Route::get('/', [TabunganController::class, 'index']);
Route::post('/tabungan', [TabunganController::class, 'store'])->name('tabungan.store');
Route::get('/rekap', [RekapController::class, 'index'])->name('rekap');

Route::get('/listpembelian', [ListPembelianController::class, 'index'])->name('pembelian');
Route::post('/listpembelian', [ListPembelianController::class, 'store'])->name('pembelian.store');
Route::post('/listpembelian/beli/{id}', [ListPembelianController::class, 'beli'])->name('pembelian.beli');