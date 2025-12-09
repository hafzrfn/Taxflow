@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Detail Tagihan Pajak</h1>
        <button onclick="window.print()" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
            🖨️ Print
        </button>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Detail Tagihan -->
        <div class="md:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6 pb-4 border-b">Informasi Tagihan</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-600">Nomor Tagihan</label>
                    <p class="text-lg font-semibold text-gray-800">TAGIHAN-{{ $tagihan->id }}-{{ $tagihan->tahun }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Objek Pajak</label>
                    <p class="text-lg font-semibold text-gray-800">{{ $tagihan->objekPajak->jenis }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $tagihan->objekPajak->alamat_objek }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Tahun Pajak</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $tagihan->tahun }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">NJOP</label>
                        <p class="text-lg font-semibold text-gray-800">Rp {{ number_format($tagihan->objekPajak->nilai_objek, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mt-6">
                    <label class="text-sm text-gray-600">Jumlah Tagihan</label>
                    <p class="text-3xl font-bold text-red-600">Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-2">Tarif: 0.5% dari NJOP</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Status Pembayaran</label>
                    <p class="mt-2">
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                            @if ($tagihan->status === 'BELUM_LUNAS')
                                bg-red-100 text-red-800
                            @elseif ($tagihan->status === 'PAYMENT_INITIATED')
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-green-100 text-green-800
                            @endif
                        ">
                            {{ $tagihan->status }}
                        </span>
                    </p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tanggal Tagihan</label>
                    <p class="text-lg text-gray-800">{{ $tagihan->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Data Wajib Pajak -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4 pb-2 border-b">Data Wajib Pajak</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <label class="text-gray-600">Nama</label>
                        <p class="font-semibold text-gray-800">{{ $wajibPajak->nama ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">NPWP</label>
                        <p class="font-semibold text-gray-800">{{ $wajibPajak->npwp ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Alamat</label>
                        <p class="font-semibold text-gray-800">{{ $wajibPajak->alamat ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                @if ($tagihan->status !== 'LUNAS')
                    <form action="{{ route('payments.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tagihan_id" value="{{ $tagihan->id }}">
                        <button class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg hover:bg-green-700 transition">
                            💳 Bayar Sekarang
                        </button>
                    </form>
                @endif

                <a href="{{ route('tagihan-pajak.print-sppt', $tagihan->id) }}" target="_blank" class="block text-center bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
                    🖨️ Download SPPT
                </a>

                <a href="{{ route('tagihan-pajak.index') }}" class="block text-center bg-gray-300 text-gray-800 font-semibold py-3 rounded-lg hover:bg-gray-400 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
