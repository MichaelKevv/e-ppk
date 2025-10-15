<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KepsekController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SiswaController;
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
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('pengaduan-data', [DashboardController::class, 'getPengaduanData']);
        Route::get('feedback-data', [DashboardController::class, 'getFeedbackData']);
        Route::get('siswa-data', [DashboardController::class, 'getSiswaData']);
        Route::resource('petugas', PetugasController::class);
        Route::resource('pengguna', PenggunaController::class);
        Route::resource('siswa', SiswaController::class);
        Route::get('siswa/edit/profile/{id}', [SiswaController::class, 'editProfile']);
        Route::put('siswa/update/profile/{id}', [SiswaController::class, 'updateProfile']);
        Route::resource('kepsek', KepsekController::class);
        Route::resource('pengaduan', PengaduanController::class);
        Route::put('pengaduan/selesai/{id}', [PengaduanController::class, 'pengaduanSelesai']);
        Route::resource('artikel', ArtikelController::class);
        Route::resource('feedback', FeedbackController::class);
        Route::get('feedback/create/{pengaduan}', [FeedbackController::class, 'create'])->name('feedback.create');
        Route::post('feedback/store/{pengaduan}', [FeedbackController::class, 'store'])->name('feedback.store');

        Route::get('export/artikel', [ArtikelController::class, 'export']);
        Route::get('export/pengguna', [PenggunaController::class, 'export']);
        Route::get('export/petugas', [PetugasController::class, 'export']);
        Route::get('export/siswa', [SiswaController::class, 'export']);
        Route::get('export/kepsek', [KepsekController::class, 'export']);
        Route::get('export/pengaduan', [PengaduanController::class, 'export']);
        Route::get('export/single/pengaduan/{id}', [PengaduanController::class, 'export_single']);
        Route::get('export/feedback', [FeedbackController::class, 'export']);
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    });
});
