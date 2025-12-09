@extends('layouts.app')
@section('title', 'Dashboard - SIM Pajak')

@section('content')
  <!-- Welcome Section -->
  <div class="mb-8 animate-slide-up">
    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">
      Selamat datang, <span class="text-gradient">{{ Auth::user()->name }}</span>
    </h1>
    <p class="text-gray-600 text-lg">
      Kelola pajak Anda dengan mudah melalui Sistem Informasi Manajemen Pajak
    </p>
  </div>

  @if(Auth::user() && Auth::user()->email === 'admin@demo.test')

    <!-- Admin Dashboard -->

    <!-- Stats Overview -->
    <div class="grid md:grid-cols-3 gap-6 mb-8 animate-slide-up stagger-1">
      <div class="stat-card">
        <div class="stat-icon">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
        <div class="stat-value">{{ $wajibs->total() }}</div>
        <div class="stat-label">Total Wajib Pajak</div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </div>
        <div class="stat-value">{{ $pendingSpts->count() }}</div>
        <div class="stat-label">SPT Menunggu Verifikasi</div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
          </svg>
        </div>
        <div class="stat-value">{{ $payments->total() }}</div>
        <div class="stat-label">Total Pembayaran</div>
      </div>
    </div>

    <!-- Daftar Wajib Pajak -->
    <div class="card mb-8 animate-slide-up stagger-2">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Wajib Pajak</h2>
      </div>

      @if($wajibs->count() == 0)
        <div class="text-center py-12 text-gray-500">
          <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
          Belum ada Wajib Pajak terdaftar.
        </div>
      @else
        <div class="overflow-x-auto scrollbar-thin">
          <table class="table-modern">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Objek Pajak</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($wajibs as $w)
                <tr>
                  <td><span class="badge badge-primary">{{ $w->id }}</span></td>
                  <td class="font-semibold">{{ $w->user->name ?? 'N/A' }}</td>
                  <td>{{ $w->nik }}</td>
                  <td><span class="badge badge-success">{{ $w->objekPajaks->count() }} Objek</span></td>
                  <td class="text-center">
                    <a href="{{ route('admin.wajib-pajaks.show', $w->id) }}" class="btn btn-primary btn-sm">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                      Lihat
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="mt-6">{{ $wajibs->links() }}</div>
      @endif
    </div>

    <!-- Verifikasi SPT -->
    <div class="card mb-8 animate-slide-up stagger-3">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Verifikasi SPT (Pengajuan e-Filing)</h2>
      </div>

      @if($pendingSpts->isEmpty())
        <div class="text-center py-12 text-gray-500">
          <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          Tidak ada SPT menunggu verifikasi.
        </div>
      @else
        <div class="overflow-x-auto scrollbar-thin">
          <table class="table-modern">
            <thead>
              <tr>
                <th>ID</th>
                <th>Wajib Pajak</th>
                <th>Tahun</th>
                <th>Penghasilan</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pendingSpts as $s)
                <tr>
                  <td><span class="badge badge-primary">{{ $s->id }}</span></td>
                  <td class="font-semibold">{{ $s->wajibPajak->user->name ?? $s->wajib_pajak_id }}</td>
                  <td>{{ $s->tahun_pajak }}</td>
                  <td class="font-semibold text-blue-600">Rp {{ number_format($s->penghasilan, 0, ',', '.') }}</td>
                  <td><span class="badge badge-warning">{{ $s->status_verifikasi }}</span></td>
                  <td class="text-center">
                    <form action="{{ route('admin.spt.verify', $s->id) }}" method="POST">
                      @csrf
                      <button class="btn btn-success btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Verifikasi
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

    <!-- Lihat Pembayaran -->
    <div class="card animate-slide-up stagger-4">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Riwayat Pembayaran</h2>
      </div>

      @if($payments->count() == 0)
        <div class="text-center py-12 text-gray-500">
          <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
          </svg>
          Belum ada pembayaran.
        </div>
      @else
        <div class="overflow-x-auto scrollbar-thin">
          <table class="table-modern">
            <thead>
              <tr>
                <th>ID</th>
                <th>User</th>
                <th>Tagihan</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($payments as $p)
                <tr>
                  <td><span class="badge badge-primary">{{ $p->id }}</span></td>
                  <td class="font-semibold">{{ $p->user->name ?? $p->user_id }}</td>
                  <td>{{ $p->tagihan->objekPajak->jenis ?? 'N/A' }} (ID: {{ $p->tagihan_pajak_id }})</td>
                  <td class="font-semibold text-green-600">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                  <td>
                    @if($p->status == 'SUCCESS')
                      <span class="badge badge-success">{{ $p->status }}</span>
                    @else
                      <span class="badge badge-warning">{{ $p->status }}</span>
                    @endif
                  </td>
                  <td class="text-sm text-gray-600">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="mt-6">{{ $payments->links() }}</div>
      @endif
    </div>

  @else

    <!-- Regular User Dashboard -->

    <!-- Quick Actions -->
    <div class="grid md:grid-cols-3 gap-6 mb-8 animate-slide-up">
      <!-- Objek Pajak Card -->
      <div>
        <a href="{{ route('objek-pajak.create') }}" class="card card-hover bg-gradient-primary text-white block mb-3">
          <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-bold">Tambah Objek Pajak</h3>
              <p class="text-sm text-blue-100">Daftarkan objek pajak baru</p>
            </div>
          </div>
        </a>
        <a href="{{ route('objek-pajak.index') }}"
          class="text-sm text-blue-600 hover:text-blue-700 transition-colors font-semibold">
          → Lihat semua objek pajak
        </a>
      </div>

      <!-- SPT Card -->
      <div>
        <a href="{{ route('spt.form') }}" class="card card-hover bg-gradient-success text-white block mb-3">
          <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-bold">Buat SPT Baru</h3>
              <p class="text-sm opacity-90">Lapor SPT secara online</p>
            </div>
          </div>
        </a>
        <a href="{{ route('spt.index') }}"
          class="text-sm text-green-600 hover:text-green-700 transition-colors font-semibold">
          → Lihat riwayat SPT dan download bukti
        </a>
      </div>

      <!-- Tagihan Card -->
      <a href="{{ route('tagihan-pajak.index') }}" class="card card-hover bg-gradient-accent text-white">
        <div class="flex items-center gap-4">
          <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
          </div>
          <div>
            <h3 class="text-xl font-bold">Lihat Tagihan</h3>
            <p class="text-sm opacity-90">Cek tagihan pajak Anda</p>
          </div>
        </div>
      </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-2 gap-6 mb-8 animate-slide-up stagger-3">
      <div class="stat-card">
        <div class="stat-icon">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <div class="stat-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
        <div class="stat-label">Total Pembayaran Anda</div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
          </svg>
        </div>
        <div class="stat-value text-red-600">Rp {{ number_format($totalTagihanBelumLunas ?? 0, 0, ',', '.') }}</div>
        <div class="stat-label">Total Tagihan Belum Lunas</div>
      </div>
    </div>

    <!-- Tagihan Section -->
    <div class="animate-slide-up stagger-4">
      <div class="card">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tagihan Anda</h2>

        @if($tagihan->isEmpty())
          <div class="text-center py-12 text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Belum terdapat tagihan.
          </div>
        @else
          <div class="overflow-x-auto scrollbar-thin">
            <table class="table-modern">
              <thead>
                <tr>
                  <th>Objek</th>
                  <th>Tahun</th>
                  <th>Jumlah</th>
                  <th>Status</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($tagihan as $obj)
                  @foreach($obj->tagihanPajaks as $t)
                    <tr>
                      <td class="font-semibold">{{ $obj->jenis }} - {{ Str::limit($obj->alamat_objek, 40) }}</td>
                      <td>{{ $t->tahun }}</td>
                      <td class="font-semibold text-blue-600">Rp {{ number_format($t->jumlah_tagihan, 0, ',', '.') }}</td>
                      <td>
                        @if($t->status == 'LUNAS')
                          <span class="badge badge-success">{{ $t->status }}</span>
                        @else
                          <span class="badge badge-danger">{{ $t->status }}</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($t->status !== 'LUNAS')
                          <form action="{{ route('payments.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tagihan_id" value="{{ $t->id }}">
                            <button class="btn btn-primary btn-sm">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                              </svg>
                              Bayar
                            </button>
                          </form>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>

    @if(session('spt_id'))
      <div class="alert alert-success mt-8 animate-slide-down">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
          <div class="font-semibold">SPT terkirim</div>
          <div class="text-sm">SPT ID: {{ session('spt_id') }}</div>
          <div class="text-sm">Receipt: {{ session('receipt_id') }}</div>
          <div class="text-xs mt-1">Tunggu verifikasi admin.</div>
        </div>
      </div>
    @endif

  @endif
@endsection