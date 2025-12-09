@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Tambah Objek Pajak</h1>

        <form action="{{ route('objek-pajak.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6 space-y-6">
            @csrf

            <!-- Jenis OP -->
            <div>
                <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Objek Pajak *
                </label>
                <select id="jenis" name="jenis" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jenis') border-red-500 @enderror">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="tanah" {{ old('jenis') === 'tanah' ? 'selected' : '' }}>Tanah</option>
                    <option value="bangunan" {{ old('jenis') === 'bangunan' ? 'selected' : '' }}>Bangunan</option>
                    <option value="kendaraan" {{ old('jenis') === 'kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                    <option value="usaha" {{ old('jenis') === 'usaha' ? 'selected' : '' }}>Usaha</option>
                </select>
                @error('jenis')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat OP -->
            <div>
                <label for="alamat_objek" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat Objek Pajak *
                </label>
                <textarea id="alamat_objek" name="alamat_objek" required rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('alamat_objek') border-red-500 @enderror" placeholder="Masukkan alamat lengkap objek pajak">{{ old('alamat_objek') }}</textarea>
                @error('alamat_objek')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Luas -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="luas" class="block text-sm font-medium text-gray-700 mb-2">
                        Luas (m²) *
                    </label>
                    <input type="number" id="luas" name="luas" required step="0.01" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('luas') border-red-500 @enderror" placeholder="Contoh: 500" value="{{ old('luas') }}">
                    @error('luas')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NJOP (Nilai Jual Objek Pajak) -->
                <div>
                    <label for="njop" class="block text-sm font-medium text-gray-700 mb-2">
                        NJOP (Rp) *
                    </label>
                    <input type="number" id="njop" name="njop" required step="1" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('njop') border-red-500 @enderror" placeholder="Contoh: 500000000" value="{{ old('njop') }}">
                    @error('njop')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Informasi Wajib Pajak -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">Wajib Pajak:</span> {{ $wajibPajak->nama ?? 'N/A' }}
                </p>
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">NPWP:</span> {{ $wajibPajak->npwp ?? 'N/A' }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
                    Simpan Objek Pajak
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg hover:bg-gray-400 transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
