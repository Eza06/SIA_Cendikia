<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginGuruController;
use App\Http\Controllers\Auth\LoginSiswaController;
use App\Http\Controllers\Guru\GuruAbsenController;
use App\Http\Controllers\Guru\GuruController as GuruGuruController;
use App\Http\Controllers\Guru\SettingsController as GuruSettingsController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasBelajarController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\RaporToController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Siswa\SiswaController as SiswaSiswaController;
use App\Http\Controllers\Siswa\SettingController as SiswaSettingController;
use App\Http\Controllers\SiswaController;

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
    // Menampilkan halaman lupa password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');

    // Mengirim kode verifikasi ke email
    Route::post('/forgot-password/send-code', [ForgotPasswordController::class, 'sendResetCode'])->name('password.send.code');

    // Memproses reset password dengan kode verifikasi
    Route::post('/reset-password-with-code', [ForgotPasswordController::class, 'resetPasswordWithCode'])->name('password.handle');
});


// =================== ADMIN ===================
Route::middleware(['auth', 'IsAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('siswa', SiswaController::class);
    Route::get('/get-siswa-by-kelas', [SiswaController::class, 'getSiswaByKelas']);
    Route::delete('/siswa/delete-selected', [SiswaController::class, 'deleteSelected'])->name('siswa.deleteSelected');

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
