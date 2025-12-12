@extends('layouts.app')
@section('title', 'Kirim SPT')

@section('content')
  <x-card title="Form Pengiriman SPT (e-Filing)">
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

      <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <h4 class="font-semibold text-blue-900 mb-2">📄 Dokumen yang Diperlukan *</h4>
        <p class="text-sm text-blue-800 mb-2">Anda <strong>wajib</strong> mengunggah minimal 1 dokumen berikut:</p>
        <ul class="list-disc list-inside text-sm text-blue-800 space-y-1">
          <li>Slip gaji / bukti penghasilan</li>
          <li>Dokumen pendukung lainnya (jika ada)</li>
        </ul>
        <p class="text-xs text-blue-700 mt-2">Format: PDF, JPG, PNG (Max 5MB per file)</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Lampiran Dokumen <span class="text-red-500">*</span>
        </label>
        <input type="file" name="attachments[]" multiple required class="mt-1 block w-full"
          accept=".pdf,.jpg,.jpeg,.png" />
        @error('attachments')
          <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
        @error('attachments.*')
          <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <button class="btn btn-primary">Kirim SPT</button>
      </div>
    </form>
  </x-card>
@endsection