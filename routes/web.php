<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;

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

Route::resource('mahasiswa', MahasiswaController::class);
//Route::get('/search', MahasiswaController::class . '@search');
Route::get('/search', [MahasiswaController::class, 'search'])->name('search');
Route::get('mahasiswa/nilai/{id_mahasiswa}', [MahasiswaController::class, 'nilai'])->name('mahasiswa.nilai');

Route::get('/', function () {
    return view('welcome');

Route::get('mahasiswa/nilai/{id_mahasiswa}', [MahasiswaController::class, 'nilai'])->name('mahasiswa.nilai');
Route::get('mahasiswa/cetak_pdf/{id_mahasiswa}', [MahasiswaController::class, 'cetak_pdf'])->name('cetak_pdf');
});
