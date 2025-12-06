@extends('layouts.app')
@section('title','Dashboard - SIM Pajak')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
  <div class="col-span-2">
    <x-card title="Tagihan Anda">
      <!-- Example: loop tagihan -->
      @if($tagihan->isEmpty())
        <div class="text-sm text-gray-600">Belum terdapat tagihan.</div>
      @else
        <x-table>
          @slot('head')
            <th class="px-4 py-2 text-left">Objek</th>
            <th class="px-4 py-2 text-left">Tahun</th>
            <th class="px-4 py-2 text-left">Jumlah</th>
            <th class="px-4 py-2 text-left">Status</th>
            <th class="px-4 py-2"></th>
          @endslot
          @slot('body')
            @foreach($tagihan as $obj)
              @foreach($obj->tagihanPajaks as $t)
              <tr class="border-t">
                <td class="px-4 py-3">{{ $obj->jenis }} - {{ Str::limit($obj->alamat_objek,40) }}</td>
                <td class="px-4 py-3">{{ $t->tahun }}</td>
                <td class="px-4 py-3">Rp {{ number_format($t->jumlah_tagihan,0,',','.') }}</td>
                <td class="px-4 py-3"><span class="text-sm {{ $t->status=='LUNAS' ? 'text-green-600' : 'text-red-600' }}">{{ $t->status }}</span></td>
                <td class="px-4 py-3">
                  @if($t->status !== 'LUNAS')
                    <form action="{{ route('payments.create') }}" method="POST">
                      @csrf
                      <input type="hidden" name="tagihan_id" value="{{ $t->id }}">
                      <button class="btn btn-primary text-sm">Bayar</button>
                    </form>
                  @endif
                </td>
              </tr>
              @endforeach
            @endforeach
          @endslot
        </x-table>
      @endif
    </x-card>
  </div>
  <div>
    <x-card title="Statistik">
      <div class="text-sm text-gray-600">Pendapatan Bulan Ini</div>
      <div class="mt-3 text-2xl font-bold">Rp {{ number_format($totalRevenue ?? 0,0,',','.') }}</div>
    </x-card>
  </div>
</div>

@if(session('spt_id'))
  <div class="mb-4 p-4 rounded bg-green-50 border border-green-200">
    <div class="font-semibold">SPT terkirim</div>
    <div class="text-sm">SPT ID: {{ session('spt_id') }}</div>
    <div class="text-sm">Receipt: {{ session('receipt_id') }}</div>
    <div class="text-xs text-gray-500 mt-1">Tunggu verifikasi admin.</div>
  </div>
@endif

@endsection
