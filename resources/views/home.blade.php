@extends('layouts.app')
@section('title','Home - TaxFlow')

@section('content')
<div class="grid md:grid-cols-2 gap-12 items-center mb-16 animate-slide-up">
  <div>
    <h1 class="text-4xl md:text-5xl font-bold mb-3">
      <span class="text-gradient">TaxFlow</span>
    </h1>
    <p class="text-xl md:text-2xl text-gray-900 font-semibold mb-4">
      Smooth, efficient tax management
    </p>
    <p class="text-lg text-gray-600 mb-8">
      Layanan digital pelaporan dan pembayaran pajak. E-filing, e-Billing, verifikasi identitas dan monitoring.
    </p>
    <div class="flex flex-col sm:flex-row gap-4">
      <a href="{{ route('spt.form') }}" class="btn btn-primary btn-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Kirim SPT
      </a>
      <a href="{{ route('payments.list') }}" class="btn btn-secondary btn-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Lihat Tagihan
      </a>
    </div>
  </div>

  <div class="card card-glass animate-slide-up stagger-1">
    <h3 class="text-2xl font-bold mb-6">Masuk Cepat</h3>
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label class="label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="input" placeholder="nama@email.com" required>
      </div>
      <div>
        <label class="label">Password</label>
        <input type="password" name="password" class="input" placeholder="••••••••" required>
      </div>
      <button class="btn btn-primary w-full">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
        </svg>
        Masuk
      </button>
      <div class="text-sm text-gray-600 text-center">
        Belum punya akun? <a href="{{ route('register') }}" class="text-gradient font-semibold">Daftar Sekarang</a>
      </div>
    </form>
  </div>
</div>

<!-- Features Section -->
<section class="mb-16">
  <div class="text-center mb-12 animate-slide-up">
    <h2 class="text-3xl md:text-4xl font-bold mb-4">
      <span class="text-gradient">Fitur Unggulan</span>
    </h2>
    <p class="text-xl text-gray-600">Kemudahan dalam mengelola pajak Anda</p>
  </div>

  <div class="grid md:grid-cols-3 gap-8">
    <div class="card card-hover animate-slide-up stagger-1">
      <div class="w-16 h-16 rounded-2xl bg-gradient-primary flex items-center justify-center text-white mb-6 shadow-lg">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
      </div>
      <h4 class="text-xl font-bold mb-3">Pendaftaran Online</h4>
      <p class="text-gray-600">Registrasi wajib pajak dengan verifikasi identitas.</p>
    </div>

    <div class="card card-hover animate-slide-up stagger-2">
      <div class="w-16 h-16 rounded-2xl bg-gradient-success flex items-center justify-center text-white mb-6 shadow-lg">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
      </div>
      <h4 class="text-xl font-bold mb-3">E-Filing</h4>
      <p class="text-gray-600">Kirim SPT dengan validasi otomatis.</p>
    </div>

    <div class="card card-hover animate-slide-up stagger-3">
      <div class="w-16 h-16 rounded-2xl bg-gradient-accent flex items-center justify-center text-white mb-6 shadow-lg">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
      </div>
      <h4 class="text-xl font-bold mb-3">E-Billing</h4>
      <p class="text-gray-600">Pembayaran terintegrasi dengan gateway.</p>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="card bg-gradient-primary text-white text-center animate-scale-in">
  <h2 class="text-3xl md:text-4xl font-bold mb-4">Mulai Kelola Pajak Anda Sekarang</h2>
  <p class="text-xl opacity-90 mb-8">Daftar gratis dan nikmati kemudahan layanan digital</p>
  <a href="{{ route('register') }}" class="btn btn-secondary btn-lg inline-flex">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
    </svg>
    Daftar Sekarang
  </a>
</section>
@endsection