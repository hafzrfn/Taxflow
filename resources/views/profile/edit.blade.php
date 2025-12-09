@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Lengkapi / Edit Profil</h1>

  @if(session('success'))
    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PATCH')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-opacity-50 px-3 py-2">
        @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" disabled
               class="mt-1 block w-full rounded-md border-gray-200 bg-gray-100 px-3 py-2">
        <div class="text-xs text-gray-500 mt-1">Email tidak bisa diubah dari sini.</div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">NIK (16 digit)</label>
        <input type="text" name="nik" value="{{ old('nik', $wajibPajak->nik) }}" maxlength="16"
               class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2">
        @error('nik') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">No. HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp', $wajibPajak->no_hp) }}"
               class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2">
        @error('no_hp') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Alamat</label>
      <textarea name="alamat" rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2">{{ old('alamat', $wajibPajak->alamat) }}</textarea>
      @error('alamat') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="flex items-center space-x-3">
      <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Simpan Profil</button>
      <a href="{{ route('dashboard') }}" class="text-sm text-gray-600">Kembali ke Dashboard</a>
    </div>
  </form>
</div>
@endsection
