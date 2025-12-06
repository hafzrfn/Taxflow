@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-8">
  <x-card title="Daftar Akun">
    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Name -->
      <x-input name="name" label="Nama" type="text" value="{{ old('name') }}" />

      <!-- Email -->
      <x-input name="email" label="Email" type="email" value="{{ old('email') }}" />

      <!-- NIK -->
      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">NIK (16 digit)</label>
        <input name="nik" type="text" maxlength="16" pattern="\d{16}" value="{{ old('nik') }}" class="input" />
        @error('nik')
          <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
        @enderror
      </div>

      <!-- Password -->
      <x-input name="password" label="Password" type="password" />
      <x-input name="password_confirmation" label="Konfirmasi Password" type="password" />

      <div class="mt-4">
        <button class="btn btn-primary w-full">Daftar</button>
      </div>
    </form>
  </x-card>
</div>
@endsection
