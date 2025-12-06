@extends('layouts.app')
@section('title','Kirim SPT')

@section('content')
<x-card title="Form Pengiriman SPT">
  <form action="{{ route('spt.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <x-input name="tahun_pajak" label="Tahun Pajak" type="number" />
    <x-input name="penghasilan" label="Penghasilan (Rp)" type="number" />
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Jenis SPT</label>
      <select name="jenis_spt" class="input">
        <option value="TAHUNAN">Tahunan</option>
        <option value="BULANAN">Bulanan</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran</label>
      <input type="file" name="attachments[]" multiple class="mt-1" />
    </div>

    <div>
      <button class="btn btn-primary">Kirim SPT</button>
    </div>
  </form>
</x-card>
@endsection
