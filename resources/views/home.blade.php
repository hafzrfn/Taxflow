@extends('layouts.app')
@section('title','Home - SIM Pajak')

@section('content')
<div class="grid md:grid-cols-2 gap-8 items-center">
  <div>
    <h1 class="text-3xl font-bold mb-4">Sistem Informasi Manajemen Pajak</h1>
    <p class="text-gray-600 mb-6">Layanan digital pelaporan dan pembayaran pajak. e-Filing, e-Billing, verifikasi identitas, dan monitoring.</p>
    <div class="flex gap-3">
      <a href="{{ route('spt.form') }}" class="btn btn-primary">Kirim SPT</a>
      <a href="{{ route('payments.list') }}" class="btn btn-ghost">Lihat Tagihan</a>
    </div>
  </div>

  <div>
    <x-card title="Masuk Cepat">
      <form action="{{ route('login') }}" method="POST" class="space-y-3">
        @csrf
        <x-input name="email" label="Email" type="email" value="{{ old('email') }}" />
        <x-input name="password" label="Password" type="password" />
        <button class="btn btn-primary w-full">Masuk</button>
        <div class="text-xs text-gray-500 mt-2">Belum punya akun? <a href="{{ route('register') }}" class="text-[var(--brand)]">Daftar</a></div>
      </form>
    </x-card>
  </div>
</div>

<section class="mt-12">
  <div class="grid md:grid-cols-3 gap-6">
    <x-card>
      <h4 class="font-semibold">Pendaftaran Online</h4>
      <p class="text-sm text-gray-600">Registrasi wajib pajak dengan verifikasi identitas.</p>
    </x-card>
    <x-card>
      <h4 class="font-semibold">E-Filing</h4>
      <p class="text-sm text-gray-600">Kirim SPT dengan validasi otomatis.</p>
    </x-card>
    <x-card>
      <h4 class="font-semibold">E-Billing</h4>
      <p class="text-sm text-gray-600">Pembayaran terintegrasi dengan gateway.</p>
    </x-card>
  </div>
</section>
@endsection
