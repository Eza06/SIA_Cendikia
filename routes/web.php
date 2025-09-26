<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginGuruController;
use App\Http\Controllers\Auth\LoginSiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\Guru\GuruAbsenController;
use App\Http\Controllers\Guru\GuruController as GuruGuruController;
use App\Http\Controllers\Guru\SettingsController as GuruSettingsController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasBelajarController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\RaporToController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Siswa\SettingController as SiswaSettingController;
use App\Http\Controllers\Siswa\SiswaController as SiswaSiswaController;
use Illuminate\Support\Facades\Route;

// =================== ROOT ===================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// =================== LOGIN & AUTH ===================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Login ganda (langsung dari login page)
Route::post('/force-login-proceed', [LoginController::class, 'forceLogin'])->name('force.login.proceed');
Route::post('/force-login-proceed-guru', [LoginGuruController::class, 'forceLogin'])->name('force.login.proceed.guru');
Route::post('/force-login-proceed-siswa', [LoginSiswaController::class, 'forceLogin'])->name('force.login.proceed.siswa');

// =================== LOGIN KHUSUS ===================
Route::get('/login-guru', [LoginGuruController::class, 'showLoginForm'])->name('login.guru');
Route::post('/login-guru', [LoginGuruController::class, 'login'])->name('login.guru.process');
Route::post('/logout-guru', [LoginGuruController::class, 'logout'])->name('logout.guru');

Route::get('/login-siswa', [LoginSiswaController::class, 'index'])->name('login.siswa');
Route::post('/login-siswa', [LoginSiswaController::class, 'login'])->name('login.siswa.process');
Route::post('/logout-siswa', [LoginSiswaController::class, 'logout'])->name('logout.siswa');

// =================== LUPA PASSWORD (UPDATED) ===================
Route::middleware('guest')->group(function () {
    // --- Rute untuk Admin & Guru (dengan kode verifikasi) ---
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/forgot-password/send-code', [ForgotPasswordController::class, 'sendResetCode'])->name('password.send.code');
    Route::post('/reset-password-with-code', [ForgotPasswordController::class, 'resetPasswordWithCode'])->name('password.handle');

    // --- [BARU] Rute untuk Siswa (tanpa kode verifikasi) ---
    Route::get('/lupa-password/siswa', [ForgotPasswordController::class, 'showStudentForgotForm'])->name('password.request.siswa');
    Route::post('/lupa-password/siswa', [ForgotPasswordController::class, 'handleStudentEmail'])->name('password.email.siswa');
    Route::get('/reset-password/siswa', [ForgotPasswordController::class, 'showStudentResetForm'])->name('password.reset.siswa');
    Route::post('/reset-password/siswa', [ForgotPasswordController::class, 'updateStudentPassword'])->name('password.update.siswa');
});

// =================== ADMIN ===================
Route::middleware(['auth', 'IsAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Rute spesifik siswa diletakkan SEBELUM Route::resource
    Route::get('/siswa/template', [SiswaController::class, 'downloadTemplate'])->name('siswa.template');
    Route::get('/siswa/export', [SiswaController::class, 'export'])->name('siswa.export');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');

    // [BARU] Route untuk memvalidasi file sebelum import (via AJAX)
    Route::post('/siswa/check-import', [SiswaController::class, 'checkImport'])->name('siswa.checkImport');

    Route::get('/get-siswa-by-kelas', [SiswaController::class, 'getSiswaByKelas']);
    Route::delete('/siswa/delete-selected', [SiswaController::class, 'deleteSelected'])->name('siswa.deleteSelected');

    // Route resource sekarang diletakkan di bawah rute spesifik
    Route::resource('siswa', SiswaController::class);

    // ... (sisa rute admin Anda) ...
    Route::resource('angkatan', AngkatanController::class);
    Route::resource('raport', RaporToController::class);
    Route::get('/raport/{rapor}/siswa/{siswa}/cetak', [RaporToController::class, 'cetakPerSiswa'])->name('raport.cetak.siswa');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/store', [SettingsController::class, 'store'])->name('settings.store');
    Route::delete('/settings/{id}', [SettingsController::class, 'destroy'])->name('settings.destroy');
    Route::resource('guru', GuruController::class);
    Route::resource('mapel', MapelController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::patch('jadwal/{id}/toggle-status', [JadwalController::class, 'toggleStatus'])->name('jadwal.toggleStatus');
    Route::resource('kelasbelajar', KelasBelajarController::class);
});

// =================== GURU ===================
Route::middleware(['auth', 'IsGuru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruGuruController::class, 'index'])->name('dashboard');
    Route::put('/jadwal/{id}/materi', [GuruGuruController::class, 'updateMateri'])->name('jadwal.materi.update');

    Route::resource('settings', GuruSettingsController::class)->only(['index'])->names([
        'index' => 'settings',
    ]);
    Route::put('settings', [GuruSettingsController::class, 'update'])->name('settings.update');

    Route::resource('absen', GuruAbsenController::class)->only(['edit', 'update']);
});

// =================== SISWA ===================
Route::middleware(['auth', 'IsSiswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaSiswaController::class, 'index'])->name('dashboard');

    Route::resource('settings', SiswaSettingController::class)->only(['index'])->names([
        'index' => 'settings',
    ]);

    Route::put('settings', [SiswaSettingController::class, 'update'])->name('settings.update');
});
