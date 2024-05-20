<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\JamKerjaController;
use App\Http\Controllers\KenekController;
use App\Http\Controllers\KepsekController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\PaletController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SatpamController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SupirController;
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

Route::get('/', [DashboardController::class, 'indexUser']);
Route::get('showarticle', [ArtikelController::class, 'indexUser']);
Route::get('kontak', [DashboardController::class, 'kontakPetugas']);
Route::get('article_detail/{id}', [ArtikelController::class, 'articleDetail']);
Route::get('register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login']);
Route::get('register', [LoginController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('register', [LoginController::class, 'register']);
Route::middleware(['auth'])->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::resource('petugas', PetugasController::class);
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('kepsek', KepsekController::class);
    Route::resource('pengaduan', PengaduanController::class);
    Route::resource('artikel', ArtikelController::class);
    Route::resource('feedback', FeedbackController::class);
    Route::get('feedback/create/{pengaduan}', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('feedback/store/{pengaduan}', [FeedbackController::class, 'store'])->name('feedback.store');
});
