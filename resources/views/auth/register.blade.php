@extends('layouts.app')
@section('title', 'Daftar - SIM Pajak')

@section('content')
  <div class="max-w-2xl mx-auto animate-slide-up">
    <div class="card">
      <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Wajib Pajak</h2>
        <p class="text-gray-600">Lengkapi data identitas Anda untuk mendaftar</p>
      </div>

      <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
          <label class="label">Nama Lengkap</label>
          <input name="name" type="text" value="{{ old('name') }}" class="input" placeholder="Masukkan nama lengkap"
            required>
          @error('name')
            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- Email -->
        <div>
          <label class="label">Email</label>
          <input name="email" type="email" value="{{ old('email') }}" class="input" placeholder="nama@email.com" required>
          @error('email')
            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- NIK -->
        <div>
          <label class="label">NIK (16 digit)</label>
          <input name="nik" type="text" maxlength="16" pattern="\d{16}" value="{{ old('nik') }}" class="input"
            placeholder="1234567890123456" required>
          @error('nik')
            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- No. HP -->
        <div>
          <label class="label">No. HP</label>
          <input name="no_hp" type="text" maxlength="20" value="{{ old('no_hp') }}" class="input"
            placeholder="08123456789" required>
          @error('no_hp')
            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- Alamat -->
        <div>
          <label class="label">Alamat</label>
          <textarea name="alamat" rows="3" class="input" placeholder="Masukkan alamat lengkap"
            required>{{ old('alamat') }}</textarea>
          @error('alamat')
            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- Password -->
        <div>
          <label class="label">Password</label>
          <input name="password" type="password" class="input" placeholder="Minimal 8 karakter" required>
          @error('password')
            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- Password Confirmation -->
        <div>
          <label class="label">Konfirmasi Password</label>
          <input name="password_confirmation" type="password" class="input" placeholder="Ulangi password" required>
        </div>

        <div class="pt-4">
          <button class="btn btn-primary w-full">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Daftar Sekarang
          </button>
          <div class="text-center mt-4 text-sm text-gray-600">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-gradient font-semibold">Masuk di sini</a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection