<?php

use App\Enums\UserRole;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\KategoriPengajuanController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\PengajuanController;
use App\Http\Controllers\Verifikator\VerifikasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// === 1. HOMEPAGE REDIRECT ===
Route::get('/', function () {
    // Jika user sudah login, arahkan ke dashboard sesuai role
    if (auth()->check()) {
        $role = auth()->user()->role->value;
        return redirect()->route("dashboard.{$role}");
    }
    // Jika belum, arahkan ke login
    return redirect()->route('login');
});

// === 2. GUEST ROUTES (Belum Login) ===
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    // Register
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    // Lupa Password & OTP
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

// === 3. AUTHENTICATED ROUTES (Sudah Login) ===
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // === DASHBOARD ROUTES ===
    // Middleware 'role' memastikan user hanya bisa akses dashboard miliknya
    Route::prefix('dashboard')->group(function () {
        Route::get('/admin', [DashboardController::class, 'admin'])
            ->middleware('role:' . UserRole::ADMIN->value)
            ->name('dashboard.admin');

        Route::get('/verifikator', [DashboardController::class, 'verifikator'])
            ->middleware('role:' . UserRole::VERIFIKATOR->value)
            ->name('dashboard.verifikator');

        Route::get('/user', [DashboardController::class, 'user'])
            ->middleware('role:' . UserRole::USER->value)
            ->name('dashboard.user');
    });
});

// === 4. ROLE BASED ROUTES ===

// A. Routes Khusus ADMIN
Route::middleware(['auth', 'role:' . UserRole::ADMIN->value])
    ->prefix('admin')
    ->name('admin.') // Prefix nama route: admin.kategori.index, admin.approval.index, dll.
    ->group(function () {
        // CRUD Kategori
        Route::resource('kategori', KategoriPengajuanController::class)->except(['show']);
        
        // Log Aktivitas
        Route::get('logs', [LogAktivitasController::class, 'index'])->name('logs.index');

        // Approval Pengajuan
        Route::get('approval', [ApprovalController::class, 'index'])->name('approval.index');
        Route::get('approval/{pengajuan}', [ApprovalController::class, 'show'])->name('approval.show');
        Route::post('approval/{pengajuan}', [ApprovalController::class, 'store'])->name('approval.store');
        
        // Manajemen User (Placeholder - Jika Anda ingin menambahkan fitur kelola user nanti)
        // Route::resource('users', UserController::class);
    });

// B. Routes Khusus VERIFIKATOR
Route::middleware(['auth', 'role:' . UserRole::VERIFIKATOR->value])
    ->prefix('verifikator')
    ->name('verifikator.')
    ->group(function () {
        // Verifikasi Pengajuan
        Route::get('verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::get('verifikasi/{pengajuan}', [VerifikasiController::class, 'show'])->name('verifikasi.show');
        Route::post('verifikasi/{pengajuan}', [VerifikasiController::class, 'store'])->name('verifikasi.store');
    });

// C. Routes Khusus USER BIASA
Route::middleware(['auth', 'role:' . UserRole::USER->value])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        // CRUD Pengajuan (User membuat & memantau pengajuan sendiri)
        Route::resource('pengajuan', PengajuanController::class);
    });