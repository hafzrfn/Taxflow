@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold mb-8">Tambah Objek Pajak</h1>

            <form action="{{ route('objek-pajak.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white rounded-lg shadow-md p-6 space-y-6">
                @csrf

                <!-- Jenis OP -->
                <div>
                    <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Objek Pajak *
                    </label>
                    <select id="jenis" name="jenis" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jenis') border-red-500 @enderror">
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

                <!-- Fields for Tanah/Bangunan -->
                <div id="fields-tanah-bangunan" class="space-y-6" style="display: none;">
                    <!-- Alamat OP -->
                    <div>
                        <label for="alamat_objek" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Objek Pajak *
                        </label>
                        <textarea id="alamat_objek" name="alamat_objek" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('alamat_objek') border-red-500 @enderror"
                            placeholder="Masukkan alamat lengkap objek pajak">{{ old('alamat_objek') }}</textarea>
                        @error('alamat_objek')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Luas -->
                    <div>
                        <label for="luas" class="block text-sm font-medium text-gray-700 mb-2">
                            Luas (m²) *
                        </label>
                        <input type="number" id="luas" name="luas" step="0.01" min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('luas') border-red-500 @enderror"
                            placeholder="Contoh: 500" value="{{ old('luas') }}">
                        @error('luas')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Fields for Kendaraan -->
                <div id="fields-kendaraan" class="space-y-6" style="display: none;">
                    <!-- Jenis Kendaraan -->
                    <div>
                        <label for="jenis_kendaraan" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kendaraan *
                        </label>
                        <select id="jenis_kendaraan" name="jenis_kendaraan"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jenis_kendaraan') border-red-500 @enderror">
                            <option value="">-- Pilih Jenis Kendaraan --</option>
                            <option value="Motor" {{ old('jenis_kendaraan') === 'Motor' ? 'selected' : '' }}>Motor</option>
                            <option value="Mobil" {{ old('jenis_kendaraan') === 'Mobil' ? 'selected' : '' }}>Mobil</option>
                            <option value="Truk" {{ old('jenis_kendaraan') === 'Truk' ? 'selected' : '' }}>Truk</option>
                            <option value="Bus" {{ old('jenis_kendaraan') === 'Bus' ? 'selected' : '' }}>Bus</option>
                        </select>
                        @error('jenis_kendaraan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Plat Nomor -->
                    <div>
                        <label for="plat_nomor" class="block text-sm font-medium text-gray-700 mb-2">
                            Plat Nomor *
                        </label>
                        <input type="text" id="plat_nomor" name="plat_nomor"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('plat_nomor') border-red-500 @enderror"
                            placeholder="Contoh: B 1234 XYZ" value="{{ old('plat_nomor') }}">
                        @error('plat_nomor')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload STNK -->
                    <div>
                        <label for="stnk" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload STNK (PDF, JPG, PNG - Max 5MB) *
                        </label>
                        <input type="file" id="stnk" name="stnk" accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stnk') border-red-500 @enderror">
                        @error('stnk')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Fields for Usaha -->
                <div id="fields-usaha" class="space-y-6" style="display: none;">
                    <!-- Nama Bisnis -->
                    <div>
                        <label for="nama_bisnis" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Bisnis *
                        </label>
                        <input type="text" id="nama_bisnis" name="nama_bisnis"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_bisnis') border-red-500 @enderror"
                            placeholder="Masukkan nama bisnis" value="{{ old('nama_bisnis') }}">
                        @error('nama_bisnis')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Bisnis -->
                    <div>
                        <label for="jenis_bisnis" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Bisnis *
                        </label>
                        <select id="jenis_bisnis" name="jenis_bisnis"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jenis_bisnis') border-red-500 @enderror">
                            <option value="">-- Pilih Jenis Bisnis --</option>
                            <option value="Perdagangan" {{ old('jenis_bisnis') === 'Perdagangan' ? 'selected' : '' }}>
                                Perdagangan</option>
                            <option value="Jasa" {{ old('jenis_bisnis') === 'Jasa' ? 'selected' : '' }}>Jasa</option>
                            <option value="Manufaktur" {{ old('jenis_bisnis') === 'Manufaktur' ? 'selected' : '' }}>Manufaktur
                            </option>
                            <option value="Kuliner" {{ old('jenis_bisnis') === 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                            <option value="Teknologi" {{ old('jenis_bisnis') === 'Teknologi' ? 'selected' : '' }}>Teknologi
                            </option>
                            <option value="Lainnya" {{ old('jenis_bisnis') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_bisnis')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat Usaha -->
                    <div>
                        <label for="alamat_objek_usaha" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Usaha *
                        </label>
                        <textarea id="alamat_objek_usaha" name="alamat_objek" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('alamat_objek') border-red-500 @enderror"
                            placeholder="Masukkan alamat lengkap usaha">{{ old('alamat_objek') }}</textarea>
                        @error('alamat_objek')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Dokumen Usaha -->
                    <div>
                        <label for="dokumen_usaha" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Dokumen Usaha (PDF, JPG, PNG - Max 5MB) *
                        </label>
                        <p class="text-xs text-gray-500 mb-2">Contoh: SIUP, TDP, NIB, atau dokumen legalitas usaha lainnya
                        </p>
                        <input type="file" id="dokumen_usaha" name="dokumen_usaha" accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('dokumen_usaha') border-red-500 @enderror">
                        @error('dokumen_usaha')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- NJOP (common for all types) -->
                <div id="field-njop" style="display: none;">
                    <label for="njop" class="block text-sm font-medium text-gray-700 mb-2">
                        NJOP / Nilai Objek Pajak (Rp) *
                    </label>
                    <input type="number" id="njop" name="njop" step="1" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('njop') border-red-500 @enderror"
                        placeholder="Contoh: 500000000" value="{{ old('njop') }}">
                    @error('njop')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Informasi Wajib Pajak -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">Wajib Pajak:</span>
                        {{ $wajibPajak->nama ?? $wajibPajak->user->name ?? 'Belum diisi' }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">NIK:</span> {{ $wajibPajak->nik ?? 'Belum diisi' }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
                        Simpan Objek Pajak
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="flex-1 bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg hover:bg-gray-400 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jenisSelect = document.getElementById('jenis');
            const fieldsTanahBangunan = document.getElementById('fields-tanah-bangunan');
            const fieldsKendaraan = document.getElementById('fields-kendaraan');
            const fieldsUsaha = document.getElementById('fields-usaha');
            const fieldNjop = document.getElementById('field-njop');

            function updateFormFields() {
                const selectedJenis = jenisSelect.value;

                // Hide all conditional fields and disable inputs
                fieldsTanahBangunan.style.display = 'none';
                fieldsKendaraan.style.display = 'none';
                fieldsUsaha.style.display = 'none';
                fieldNjop.style.display = 'none';

                // Disable all fields when hidden
                document.querySelectorAll('#fields-tanah-bangunan input, #fields-tanah-bangunan textarea').forEach(el => {
                    el.removeAttribute('required');
                    el.disabled = true;
                });
                document.querySelectorAll('#fields-kendaraan input, #fields-kendaraan select').forEach(el => {
                    el.removeAttribute('required');
                    el.disabled = true;
                });
                document.querySelectorAll('#fields-usaha input, #fields-usaha select, #fields-usaha textarea').forEach(el => {
                    el.removeAttribute('required');
                    el.disabled = true;
                });
                document.getElementById('njop').disabled = true;
                document.getElementById('njop').removeAttribute('required');

                // Show relevant fields based on selection and enable them
                if (selectedJenis === 'tanah' || selectedJenis === 'bangunan') {
                    fieldsTanahBangunan.style.display = 'block';
                    fieldNjop.style.display = 'block';
                    // Enable and set required
                    document.getElementById('alamat_objek').disabled = false;
                    document.getElementById('alamat_objek').setAttribute('required', 'required');
                    document.getElementById('luas').disabled = false;
                    document.getElementById('luas').setAttribute('required', 'required');
                    document.getElementById('njop').disabled = false;
                    document.getElementById('njop').setAttribute('required', 'required');
                } else if (selectedJenis === 'kendaraan') {
                    fieldsKendaraan.style.display = 'block';
                    fieldNjop.style.display = 'block';
                    // Enable and set required
                    document.getElementById('jenis_kendaraan').disabled = false;
                    document.getElementById('jenis_kendaraan').setAttribute('required', 'required');
                    document.getElementById('plat_nomor').disabled = false;
                    document.getElementById('plat_nomor').setAttribute('required', 'required');
                    document.getElementById('stnk').disabled = false;
                    document.getElementById('stnk').setAttribute('required', 'required');
                    document.getElementById('njop').disabled = false;
                    document.getElementById('njop').setAttribute('required', 'required');
                } else if (selectedJenis === 'usaha') {
                    fieldsUsaha.style.display = 'block';
                    fieldNjop.style.display = 'block';
                    // Enable and set required
                    document.getElementById('nama_bisnis').disabled = false;
                    document.getElementById('nama_bisnis').setAttribute('required', 'required');
                    document.getElementById('jenis_bisnis').disabled = false;
                    document.getElementById('jenis_bisnis').setAttribute('required', 'required');
                    document.getElementById('alamat_objek_usaha').disabled = false;
                    document.getElementById('alamat_objek_usaha').setAttribute('required', 'required');
                    document.getElementById('dokumen_usaha').disabled = false;
                    document.getElementById('dokumen_usaha').setAttribute('required', 'required');
                    document.getElementById('njop').disabled = false;
                    document.getElementById('njop').setAttribute('required', 'required');
                }
            }

            // Listen for changes
            jenisSelect.addEventListener('change', updateFormFields);

            // Initialize on page load
            updateFormFields();
        });
    </script>
@endsection