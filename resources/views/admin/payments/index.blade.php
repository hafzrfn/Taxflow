@extends('layouts.app')
@section('title','Pembayaran')

@section('content')
<h1 class="text-2xl font-bold mb-4">Daftar Pembayaran</h1>

<div class="bg-white rounded shadow overflow-hidden">
  <table class="w-full">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">User</th>
        <th class="px-4 py-2">Tagihan</th>
        <th class="px-4 py-2">Jumlah</th>
        <th class="px-4 py-2">Status</th>
        <th class="px-4 py-2">Tanggal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($payments as $p)
      <tr class="border-t">
        <td class="px-4 py-2">{{ $p->id }}</td>
        <td class="px-4 py-2">{{ $p->user->name ?? $p->user_id }}</td>
        <td class="px-4 py-2">{{ $p->tagihan->objekPajak->jenis ?? 'N/A' }} (ID: {{ $p->tagihan_pajak_id }})</td>
        <td class="px-4 py-2">Rp {{ number_format($p->jumlah_bayar,0,',','.') }}</td>
        <td class="px-4 py-2">{{ $p->status }}</td>
        <td class="px-4 py-2">{{ $p->created_at->format('d/m/Y H:i') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $payments->links() }}</div>

@endsection
