@extends('layouts.app')
@section('title','Daftar Tagihan')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
  <div class="col-span-2">
    <x-card title="Daftar Tagihan">
      @if($tagihan->isEmpty())
        <div class="text-sm text-gray-600">Belum ada tagihan.</div>
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
                <td class="px-4 py-3">{{ $obj->jenis }} - {{ \Illuminate\Support\Str::limit($obj->alamat_objek,40) }}</td>
                <td class="px-4 py-3">{{ $t->tahun }}</td>
                <td class="px-4 py-3">Rp {{ number_format($t->jumlah_tagihan,0,',','.') }}</td>
                <td class="px-4 py-3">
                  <span class="text-sm {{ $t->status=='LUNAS' ? 'text-green-600' : 'text-red-600' }}">{{ $t->status }}</span>
                </td>
                <td class="px-4 py-3">
                  @if($t->status !== 'LUNAS')
                    <form action="{{ route('payments.create') }}" method="POST">
                      @csrf
                      <input type="hidden" name="tagihan_id" value="{{ $t->id }}">
                      <button class="btn btn-primary text-sm">Bayar</button>
                    </form>
                  @else
                    {{-- Jika ada pembayaran dan ada kode_billing, tampilkan link, jika tidak tampilkan tanda "-" --}}
                    @if(isset($t->pembayaran) && !empty($t->pembayaran->kode_billing))
                        <a href="{{ route('payment.page', ['kode' => $t->pembayaran->kode_billing]) }}" class="text-sm text-blue-600">Lihat bukti</a>
                    @else
                        <span class="text-sm text-gray-500">-</span>
                    @endif
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
    <x-card title="Pembayaran Terakhir">
      @if($recentPayments->isEmpty())
        <div class="text-sm text-gray-600">Belum ada pembayaran.</div>
      @else
        <ul class="space-y-2">
          @foreach($recentPayments as $pay)
            <li class="flex justify-between items-center">
              <div>
                <div class="text-sm font-medium">{{ $pay->kode_billing }}</div>
                <div class="text-xs text-gray-500">Rp {{ number_format($pay->jumlah_bayar,0,',','.') }}</div>
              </div>
              <div class="text-sm {{ $pay->status==='SUCCESS' ? 'text-green-600' : 'text-yellow-600' }}">{{ $pay->status }}</div>
            </li>
          @endforeach
        </ul>
      @endif
    </x-card>
  </div>
</div>
@endsection
