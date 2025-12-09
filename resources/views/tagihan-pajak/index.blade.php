@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Tagihan Pajak Saya</h1>

    @if (session('success'))
        <div class="mb-4 p-4 rounded bg-green-50 border border-green-200">
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 rounded bg-red-50 border border-red-200">
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Summary Card -->
    <div class="grid md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <p class="text-sm text-gray-600">Total Tagihan Belum Lunas</p>
            <p class="text-3xl font-bold text-red-600 mt-2">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-600">Tagihan Dalam Proses</p>
            <p class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $tagihans->getCollection()->where('status', 'PAYMENT_INITIATED')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <p class="text-sm text-gray-600">Tagihan Lunas</p>
            <p class="text-3xl font-bold text-green-600 mt-2">
                {{ $tagihans->getCollection()->where('status', 'LUNAS')->count() }}
            </p>
        </div>
    </div>

    @if ($tagihans->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <p class="text-yellow-800">Belum ada tagihan pajak. Tambahkan Objek Pajak terlebih dahulu, kemudian admin akan membuat tagihan otomatis.</p>
            <a href="{{ route('objek-pajak.create') }}" class="mt-4 inline-block bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                + Tambah Objek Pajak
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Objek Pajak</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tahun</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jumlah Tagihan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tagihans as $tagihan)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm text-gray-800">
                                <div class="font-semibold">{{ $tagihan->objekPajak->jenis }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($tagihan->objekPajak->alamat_objek, 50) }}</div>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-800 font-semibold">{{ $tagihan->tahun }}</td>
                            <td class="px-6 py-3 text-sm text-gray-800 font-bold text-lg">
                                Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-3 text-sm">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
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
                            </td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex gap-2 justify-center flex-wrap">
                                    @if ($tagihan->status !== 'LUNAS')
                                        <form action="{{ route('payments.create') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="tagihan_id" value="{{ $tagihan->id }}">
                                            <button class="bg-green-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-green-700 transition">
                                                💳 Bayar
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('tagihan-pajak.print-sppt', $tagihan->id) }}" target="_blank" class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-blue-700 transition">
                                        🖨️ Print SPPT
                                    </a>
                                    <a href="{{ route('tagihan-pajak.show', $tagihan->id) }}" class="bg-gray-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-gray-700 transition">
                                        👁️ Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $tagihans->links() }}
        </div>
    @endif
</div>
@endsection
