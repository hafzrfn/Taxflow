@extends('layouts.app')
@section('title','Detail Wajib Pajak')

@section('content')
<div class="mb-6">
  <h1 class="text-2xl font-bold mb-2">{{ $wajib->nama }} (ID: {{ $wajib->id }})</h1>
  <p class="text-sm text-gray-600">NIK: {{ $wajib->nik }} — NPWP: {{ $wajib->npwp }}</p>
</div>

<div class="mb-6">
  <h2 class="text-xl font-semibold mb-2">Objek Pajak</h2>
  @if($wajib->objekPajaks->isEmpty())
    <div class="text-sm text-gray-600">Belum ada objek pajak.</div>
  @else
    <div class="bg-white rounded shadow overflow-hidden">
      <table class="w-full">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Jenis</th>
            <th class="px-4 py-2 text-left">Alamat</th>
            <th class="px-4 py-2 text-left">Nilai</th>
            <th class="px-4 py-2 text-left">Tagihan</th>
          </tr>
        </thead>
        <tbody>
          @foreach($wajib->objekPajaks as $o)
          <tr class="border-t">
            <td class="px-4 py-2">{{ $o->id }}</td>
            <td class="px-4 py-2">{{ ucfirst($o->jenis) }}</td>
            <td class="px-4 py-2">{{ $o->alamat_objek }}</td>
            <td class="px-4 py-2">Rp {{ number_format($o->nilai_objek,0,',','.') }}</td>
            <td class="px-4 py-2">
              @foreach($o->tagihanPajaks as $t)
                <div class="mb-1">
                  <strong>{{ $t->tahun }}</strong>: Rp {{ number_format($t->jumlah_tagihan,0,',','.') }} — <span class="{{ $t->status=='LUNAS' ? 'text-green-600' : 'text-red-600' }}">{{ $t->status }}</span>
                </div>
              @endforeach
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

<div>
  <h2 class="text-xl font-semibold mb-2">SPT</h2>
  @if($spts->isEmpty())
    <div class="text-sm text-gray-600">Tidak ada SPT.</div>
  @else
    <div class="bg-white rounded shadow overflow-hidden">
      <table class="w-full">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">No Bukti</th>
            <th class="px-4 py-2">Tahun</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($spts as $s)
          <tr class="border-t">
            <td class="px-4 py-2">{{ $s->id }}</td>
            <td class="px-4 py-2">{{ $s->receipt_id }}</td>
            <td class="px-4 py-2">{{ $s->tahun_pajak }}</td>
            <td class="px-4 py-2">{{ $s->status_verifikasi }}</td>
            <td class="px-4 py-2">
              @if($s->status_verifikasi !== 'VERIFIED')
                <form action="{{ route('admin.spt.verify', $s->id) }}" method="POST">
                  @csrf
                  <button class="btn btn-primary text-sm">Verifikasi</button>
                </form>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

@endsection
