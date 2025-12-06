@extends('layouts.app')
@section('title','Kirim Pengaduan')

@section('content')
<x-card title="Kirim Pengaduan">
  <form action="{{ route('pengaduan.store') }}" method="POST" class="space-y-3">
    @csrf
    <x-input name="judul" label="Judul" />
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Isi</label>
      <textarea name="isi" class="input h-32"></textarea>
    </div>
    <button class="btn btn-primary">Kirim</button>
  </form>
</x-card>
@endsection
