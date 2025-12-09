@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Daftar Objek Pajak Saya</h1>
        <a href="{{ route('objek-pajak.create') }}" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
            + Tambah Objek Pajak
        </a>
    </div>

    @if ($objekPajaks->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <p class="text-yellow-800">Anda belum memiliki objek pajak. <a href="{{ route('objek-pajak.create') }}" class="font-semibold underline">Tambah sekarang</a></p>
        </div>
    @else
        <div class="grid gap-6">
            @foreach ($objekPajaks as $objek)
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-600">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Jenis Objek Pajak</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $objek->jenis }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">NJOP (Nilai Jual Objek Pajak)</p>
                            <p class="text-lg font-semibold text-gray-800">Rp {{ number_format($objek->nilai_objek, 0, ',', '.') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Alamat</p>
                            <p class="text-gray-800">{{ $objek->alamat_objek }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Dibuat</p>
                            <p class="text-gray-800">{{ $objek->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
