@extends('layouts.app')
@section('title','Admin Dashboard')

@section('content')
<div class="mb-6">
  <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
  <div class="grid grid-cols-4 gap-4">
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm text-gray-500">Wajib Pajak</div>
      <div class="text-2xl font-bold">{{ $totalWajib }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm text-gray-500">Objek Pajak</div>
      <div class="text-2xl font-bold">{{ $totalObjek }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm text-gray-500">Tagihan</div>
      <div class="text-2xl font-bold">{{ $totalTagihan }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm text-gray-500">Pembayaran</div>
      <div class="text-2xl font-bold">{{ $totalPayments }}</div>
    </div>
  </div>

  <div class="mt-6">
    <a href="{{ route('admin.wajib-pajaks.index') }}" class="btn btn-primary">Lihat Daftar Wajib Pajak</a>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-ghost">Lihat Pembayaran</a>
  </div>
</div>
@endsection
@extends('layouts.app')
@section('title','Admin Dashboard')

@section('content')
<div class="grid grid-cols-4 gap-6">
  <div class="col-span-3">
    <x-card title="Pending SPT">
      <div class="text-sm text-gray-600">Jumlah SPT menunggu verifikasi: {{ $pendingSPT ?? 0 }}</div>
      <div class="mt-3">
        <a href="{{ route('admin.spt.index') }}" class="btn btn-ghost">Lihat SPT</a>
      </div>
    </x-card>
    <x-card class="mt-6">
      <h4 class="font-semibold">Recent Payments</h4>
      <!-- You can list latest payments here -->
      <div class="text-sm text-gray-500 mt-2">(Sample data)</div>
    </x-card>
  </div>
  <div>
    <x-card title="Quick Actions">
      <a href="{{ route('admin.pengaduan.index') }}" class="block text-sm py-2">Tinjau Pengaduan</a>
      <a href="{{ route('admin.pengaduan.index') }}" class="block text-sm py-2">Verifikasi SPT</a>
    </x-card>
  </div>
</div>
@endsection
