@extends('layouts.app')
@section('title', 'Dashboard - SIM Pajak')

@section('content')
  <!-- Welcome Section -->
  <div class="mb-8">
    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">
      Selamat datang, <span class="text-blue-600">{{ Auth::user()->name }}</span>
    </h1>
    <p class="text-gray-600 text-lg">
      Kelola pajak Anda dengan mudah melalui Sistem Informasi Manajemen Pajak
    </p>
  </div>

  @if(Auth::user() && Auth::user()->email === 'admin@demo.test')

    <!-- Admin: Lihat Daftar Wajib Pajak -->
    <div class="mb-6">
      <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold text-gray-800">Daftar Wajib Pajak</h2>
        </div>

        @if($wajibs->count() == 0)
          <div class="text-sm text-gray-600">Belum ada Wajib Pajak terdaftar.</div>
        @else
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-100">
                <tr>
                  <th class="px-4 py-2 text-left">ID</th>
                  <th class="px-4 py-2 text-left">Nama</th>
                  <th class="px-4 py-2 text-left">NIK</th>
                  <th class="px-4 py-2 text-left">Objek</th>
                  <th class="px-4 py-2"></th>
                </tr>
              </thead>
              <tbody>
                @foreach($wajibs as $w)
                  <tr class="border-t">
                    <td class="px-4 py-2">{{ $w->id }}</td>
                    <td class="px-4 py-2">{{ $w->user->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $w->nik }}</td>
                    <td class="px-4 py-2">{{ $w->objekPajaks->count() }}</td>
                    <td class="px-4 py-2">
                      <a href="{{ route('admin.wajib-pajaks.show', $w->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="mt-3">{{ $wajibs->links() }}</div>
        @endif
      </div>
    </div>

    <!-- Admin: Verifikasi SPT -->
    <div class="mb-6">
      <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold text-gray-800">Verifikasi SPT (Pengajuan e-Filing)</h2>
        </div>

        @if($pendingSpts->isEmpty())
          <div class="text-sm text-gray-600">Tidak ada SPT menunggu verifikasi.</div>
        @else
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-100">
                <tr>
                  <th class="px-4 py-2">ID</th>
                  <th class="px-4 py-2">Wajib Pajak</th>
                  <th class="px-4 py-2">Tahun</th>
                  <th class="px-4 py-2">Penghasilan</th>
                  <th class="px-4 py-2">Status</th>
                  <th class="px-4 py-2"></th>
                </tr>
              </thead>
              <tbody>
                @foreach($pendingSpts as $s)
                  <tr class="border-t">
                    <td class="px-4 py-2">{{ $s->id }}</td>
                    <td class="px-4 py-2">{{ $s->wajibPajak->nama ?? $s->wajib_pajak_id }}</td>
                    <td class="px-4 py-2">{{ $s->tahun_pajak }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($s->penghasilan, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $s->status_verifikasi }}</td>
                    <td class="px-4 py-2">
                      <form action="{{ route('admin.spt.verify', $s->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary text-sm">Verifikasi</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>

    <!-- Admin: Lihat Pembayaran -->
    <div class="mb-6">
      <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold text-gray-800">Lihat Pembayaran</h2>
        </div>

        @if($payments->count() == 0)
          <div class="text-sm text-gray-600">Belum ada pembayaran.</div>
        @else
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-100">
                <tr>
                  <th class="px-4 py-2">ID</th>
                  <th class="px-4 py-2">User</th>
                  <th class="px-4 py-2">Tagihan</th>
                  <th class="px-4 py-2">Jumlah</th>
                  <th class="px-4 py-2">Status</th>
                  <th class="px-4 py-2">Tanggal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($payments as $p)
                  <tr class="border-t">
                    <td class="px-4 py-2">{{ $p->id }}</td>
                    <td class="px-4 py-2">{{ $p->user->name ?? $p->user_id }}</td>
                    <td class="px-4 py-2">{{ $p->tagihan->objekPajak->jenis ?? 'N/A' }} (ID: {{ $p->tagihan_pajak_id }})</td>
                    <td class="px-4 py-2">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $p->status }}</td>
                    <td class="px-4 py-2">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="mt-3">{{ $payments->links() }}</div>
        @endif
      </div>
    </div>

  @else

    <!-- Regular user dashboard (kept original) -->

    <!-- Objek Pajak Section -->
    <div class="mb-6">
      <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold text-gray-800">Objek Pajak Saya</h2>
          <a href="{{ route('objek-pajak.create') }}"
            class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
            + Tambah Objek Pajak
          </a>
        </div>
        <a href="{{ route('objek-pajak.index') }}" class="text-blue-600 hover:underline text-sm">
          Lihat semua objek pajak →
        </a>
      </div>
    </div>

    <!-- SPT Section -->
    <div class="mb-6">
      <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold text-gray-800">SPT Saya</h2>
          <a href="{{ route('spt.form') }}"
            class="bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition">
            + Buat SPT Baru
          </a>
        </div>
        <a href="{{ route('spt.index') }}" class="text-blue-600 hover:underline text-sm">
          Lihat riwayat SPT dan download bukti penerimaan →
        </a>
      </div>
    </div>

    <!-- Tagihan Pajak Section -->
    <div class="mb-6">
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
        <div class="flex justify-between items-center mb-4">
          <div>
            <h2 class="text-xl font-bold text-gray-800">Tagihan Pajak Saya</h2>
            <p class="text-sm text-red-600 font-semibold mt-1">Total Tagihan Belum Lunas: Rp
              {{ number_format($totalTagihanBelumLunas ?? 0, 0, ',', '.') }}</p>
          </div>
          <a href="{{ route('tagihan-pajak.index') }}"
            class="bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700 transition">
            Lihat Semua
          </a>
        </div>
      </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
      <div class="col-span-2">
        <x-card title="Tagihan Anda">
          <!-- Example: loop tagihan -->
          @if($tagihan->isEmpty())
            <div class="text-sm text-gray-600">Belum terdapat tagihan.</div>
          @else
            <x-table>
              @slot('head')
              <th class="px-4 py-2 text-left">Objek</th>
              <th class="px-4 py-2 text-left">Tahun</th>
              <th class="px-4 py-2 text-left">Jumlah</th>
              <th class="px-4 py-2 text-left">Status</th>
              <th class="px-4 py-2"></th>
              @endslot
              @slot('body')
              @foreach($tagihan as $obj)
                @foreach($obj->tagihanPajaks as $t)
                  <tr class="border-t">
                    <td class="px-4 py-3">{{ $obj->jenis }} - {{ Str::limit($obj->alamat_objek, 40) }}</td>
                    <td class="px-4 py-3">{{ $t->tahun }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($t->jumlah_tagihan, 0, ',', '.') }}</td>
                    <td class="px-4 py-3"><span
                        class="text-sm {{ $t->status == 'LUNAS' ? 'text-green-600' : 'text-red-600' }}">{{ $t->status }}</span></td>
                    <td class="px-4 py-3">
                      @if($t->status !== 'LUNAS')
                        <form action="{{ route('payments.create') }}" method="POST">
                          @csrf
                          <input type="hidden" name="tagihan_id" value="{{ $t->id }}">
                          <button class="btn btn-primary text-sm">Bayar</button>
                        </form>
                      @endif
                    </td>
                  </tr>
                @endforeach
              @endforeach
              @endslot
            </x-table>
          @endif
        </x-card>
      </div>
      <div>
        <x-card title="Statistik">
          <div class="text-sm text-gray-600">Pendapatan Bulan Ini</div>
          <div class="mt-3 text-2xl font-bold">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
        </x-card>
      </div>
    </div>

    @if(session('spt_id'))
      <div class="mb-4 p-4 rounded bg-green-50 border border-green-200">
        <div class="font-semibold">SPT terkirim</div>
        <div class="text-sm">SPT ID: {{ session('spt_id') }}</div>
        <div class="text-sm">Receipt: {{ session('receipt_id') }}</div>
        <div class="text-xs text-gray-500 mt-1">Tunggu verifikasi admin.</div>
      </div>
    @endif

  @endif
@endsection