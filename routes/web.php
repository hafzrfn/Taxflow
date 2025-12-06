<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\SPTController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\DashboardController;

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard (user)
    Route::get('/dashboard', [DashboardController::class, 'user'])
        ->name('dashboard');

    // SPT (e-Filing)
    // simple form view (Blade)
    Route::get('/spt/form', function () {
        return view('spt.form');
    })->name('spt.form');

    Route::post('/spt', [SPTController::class, 'submit'])->name('spt.submit');

    // Payments (e-Billing)
    Route::get('/payments', [\App\Http\Controllers\BillingController::class, 'index'])->name('payments.list');
    Route::post('/payments/create', [BillingController::class, 'createPayment'])->name('payments.create');
    Route::get('/payments/page/{kode}', [BillingController::class, 'paymentPage'])->name('payment.page');
    Route::post('/payments/simulate/{kode}', [BillingController::class, 'simulateGatewayPay'])->name('payment.simulate');

    // Pengaduan (user)
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
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
