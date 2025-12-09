@extends('layouts.app')
@section('title','Daftar Wajib Pajak')

@section('content')
<h1 class="text-2xl font-bold mb-4">Daftar Wajib Pajak</h1>

<div class="bg-white rounded shadow overflow-hidden">
  <table class="w-full">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2 text-left">ID</th>
        <th class="px-4 py-2 text-left">Nama</th>
        <th class="px-4 py-2 text-left">NIK</th>
        <th class="px-4 py-2 text-left">Objek Count</th>
        <th class="px-4 py-2"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($wajibs as $w)
      <tr class="border-t">
        <td class="px-4 py-2">{{ $w->id }}</td>
        <td class="px-4 py-2">{{ $w->nama }}</td>
        <td class="px-4 py-2">{{ $w->nik }}</td>
        <td class="px-4 py-2">{{ $w->objek_pajaks_count ?? $w->objekPajaks()->count() }}</td>
        <td class="px-4 py-2">
          <a href="{{ route('admin.wajib-pajaks.show', $w->id) }}" class="text-blue-600 hover:underline">Lihat</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $wajibs->links() }}</div>

@endsection
