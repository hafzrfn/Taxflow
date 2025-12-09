<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\SPTController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObjekPajakController;
use App\Http\Controllers\TagihanPajakController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group.
|
*/

// Public / Landing
Route::get('/', function () {
    return view('home'); // use resources/views/home.blade.php
})->name('home');

// Public registration endpoint (user is not authenticated yet)
// routes/web.php should have
Route::post('/register', [\App\Http\Controllers\Auth\RegistrationController::class, 'register'])->name('register');


// Authenticated routes (user)
Route::middleware(['auth'])->group(function () {

    // Profile (provided by Breeze or custom)
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard (user)
    Route::get('/dashboard', [DashboardController::class, 'user'])
        ->name('dashboard');

    // Admin routes (only admin@demo.test)
    // Use the middleware class directly to avoid alias resolution/caching issues
    Route::middleware([\App\Http\Middleware\AdminOnly::class])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/wajib-pajaks', [\App\Http\Controllers\AdminController::class, 'wajibPajaks'])->name('wajib-pajaks.index');
        Route::get('/wajib-pajaks/{id}', [\App\Http\Controllers\AdminController::class, 'showWajibPajak'])->name('wajib-pajaks.show');
        Route::post('/spt/{id}/verify', [\App\Http\Controllers\AdminController::class, 'verifySpt'])->name('spt.verify');
        Route::get('/payments', [\App\Http\Controllers\AdminController::class, 'payments'])->name('payments.index');
    });

    // SPT (e-Filing)
    // simple form view (Blade)
    Route::get('/spt/form', function () {
        return view('spt.form');
    })->name('spt.form');

    Route::post('/spt', [SPTController::class, 'submit'])->name('spt.submit');
    Route::get('/spt', [SPTController::class, 'index'])->name('spt.index');
    Route::get('/spt/{id}/download-receipt', [SPTController::class, 'downloadReceipt'])->name('spt.downloadReceipt');

    // Payments (e-Billing)
    Route::get('/payments', [\App\Http\Controllers\BillingController::class, 'index'])->name('payments.list');
    Route::post('/payments/create', [BillingController::class, 'createPayment'])->name('payments.create');
    Route::get('/payments/page/{kode}', [BillingController::class, 'paymentPage'])->name('payment.page');
    Route::post('/payments/simulate/{kode}', [BillingController::class, 'simulateGatewayPay'])->name('payment.simulate');

    // Pengaduan (user)
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

    // Objek Pajak (user)
    Route::get('/objek-pajak', [ObjekPajakController::class, 'index'])->name('objek-pajak.index');
    Route::get('/objek-pajak/create', [ObjekPajakController::class, 'create'])->name('objek-pajak.create');
    Route::post('/objek-pajak', [ObjekPajakController::class, 'store'])->name('objek-pajak.store');

    // Tagihan Pajak (user)
    Route::get('/tagihan-pajak', [TagihanPajakController::class, 'index'])->name('tagihan-pajak.index');
    Route::get('/tagihan-pajak/{id}', [TagihanPajakController::class, 'show'])->name('tagihan-pajak.show');
    Route::get('/tagihan-pajak/{id}/print-sppt', [TagihanPajakController::class, 'printSPPT'])->name('tagihan-pajak.print-sppt');
});

// Admin routes (requires auth + role:admin)
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // Pengaduan management
    Route::get('/admin/pengaduan', [PengaduanController::class, 'indexAdmin'])->name('admin.pengaduan.index');
    Route::post('/admin/pengaduan/{pengaduan}/respond', [PengaduanController::class, 'respond'])->name('admin.pengaduan.respond');

    // You can add more admin-only routes here (SPT verification, payments overview, etc.)
});

// Webhook callback (payment gateway).
// Note: this route is exempted from CSRF verification in VerifyCsrfToken ($except),
// and should verify gateway signature in controller.
Route::post('/api/payments/callback', [PaymentCallbackController::class, 'handle'])
    ->name('payments.callback');

// Include auth routes (Breeze / Fortify / default)
require __DIR__.'/auth.php';
