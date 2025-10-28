<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KepsekController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DinsosController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\DecisionTreeController;
use App\Http\Controllers\TAMController;
use App\Http\Controllers\SurveyDataController;
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
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('pengaduan-data', [DashboardController::class, 'getPengaduanData']);
        Route::get('feedback-data', [DashboardController::class, 'getFeedbackData']);
        Route::get('siswa-data', [DashboardController::class, 'getSiswaData']);
        Route::resource('admin', AdminController::class);
        Route::resource('dinsos', DinsosController::class);
        Route::resource('pengguna', PenggunaController::class);
        Route::resource('siswa', SiswaController::class);
        Route::get('siswa/edit/profile/{id}', [SiswaController::class, 'editProfile']);
        Route::put('siswa/update/profile/{id}', [SiswaController::class, 'updateProfile']);

        // Route::post('/admin/feedback/survey', [FeedbackController::class, 'storeSurvey'])->name('feedback.survey.store');
        Route::prefix('survey')->name('survey.')->group(function () {
            Route::get('/', [SurveyDataController::class, 'index'])->name('index');
            Route::get('/create', [SurveyDataController::class, 'create'])->name('create');
            Route::post('/store', [SurveyDataController::class, 'store'])->name('store');
            Route::get('/show/{id}', [SurveyDataController::class, 'show'])->name('show');
            Route::delete('/destroy/{id}', [SurveyDataController::class, 'destroy'])->name('destroy');
            Route::get('/analysis', [SurveyDataController::class, 'analysis'])->name('analysis');
        });

        // Routes untuk Pengaduan - PERBAIKI DI SINI
        Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
            Route::get('/', [PengaduanController::class, 'index'])->name('index');
            Route::get('/create', [PengaduanController::class, 'create'])->name('create');
            Route::post('/', [PengaduanController::class, 'store'])->name('store');
            Route::get('/{id}', [PengaduanController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [PengaduanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PengaduanController::class, 'update'])->name('update');
            Route::delete('/{id}', [PengaduanController::class, 'destroy'])->name('destroy');
            Route::put('/selesai/{id}', [PengaduanController::class, 'pengaduanSelesai'])->name('selesai');
            Route::get('/export/all', [PengaduanController::class, 'export'])->name('export');
            Route::get('/export/{id}', [PengaduanController::class, 'export_single'])->name('export_single');
        });

        Route::resource('artikel', ArtikelController::class);
        Route::resource('feedback', FeedbackController::class);
        Route::get('feedback/create/{pengaduan}', [FeedbackController::class, 'create'])->name('feedback.create');
        Route::post('feedback/store/{pengaduan}', [FeedbackController::class, 'store'])->name('feedback.store');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/decision-tree', [DecisionTreeController::class, 'index'])->name('decision-tree.index');
        Route::post('/decision-tree/proses', [DecisionTreeController::class, 'proses'])->name('decision-tree.proses');
        Route::post('/decision-tree/classify', [DecisionTreeController::class, 'classify'])->name('decision-tree.classify');
        Route::get('/tam', [TAMController::class, 'index'])->name('tam.index');
        Route::post('/tam/hitung', [TAMController::class, 'hitung'])->name('tam.hitung');

        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
