@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Riwayat SPT Saya</h1>
        <a href="{{ route('spt.form') }}" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
            + Buat SPT Baru
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 rounded bg-green-50 border border-green-200">
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 rounded bg-red-50 border border-red-200">
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    @if ($spts->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <p class="text-yellow-800">Anda belum membuat SPT. <a href="{{ route('spt.form') }}" class="font-semibold underline">Buat sekarang</a></p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No. Bukti</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tahun Pajak</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jenis SPT</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Penghasilan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spts as $spt)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm text-gray-800">
                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $spt->receipt_id }}</span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-800">{{ $spt->tahun_pajak }}</td>
                            <td class="px-6 py-3 text-sm text-gray-800">{{ $spt->jenis_spt }}</td>
                            <td class="px-6 py-3 text-sm text-gray-800">Rp {{ number_format($spt->penghasilan, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-sm">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    @if ($spt->status_verifikasi === 'PENDING')
                                        bg-yellow-100 text-yellow-800
                                    @elseif ($spt->status_verifikasi === 'VERIFIED')
                                        bg-green-100 text-green-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ $spt->status_verifikasi }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $spt->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('spt.downloadReceipt', $spt->id) }}" class="text-blue-600 hover:underline text-sm font-semibold" title="Download Bukti Penerimaan">
                                        📥 Download
                                    </a>
                                    <button type="button" onclick="showDetails('{{ $spt->id }}')" class="text-gray-600 hover:underline text-sm font-semibold" title="Lihat Detail">
                                        👁️ Detail
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $spts->links() }}
        </div>
    @endif
</div>

<!-- Detail Modal -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" onclick="closeDetails()">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl w-full mx-4" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Detail SPT</h2>
            <button onclick="closeDetails()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <div id="detailContent" class="space-y-4">
            <!-- Content akan diisi via JavaScript -->
        </div>
    </div>
</div>

<script type="text/javascript">
    // SPT Data passed from Blade as JSON string
    var sptDataJson = {!! json_encode($spts->toArray()) !!};
    const sptData = {};
    sptDataJson.forEach(item => {
        sptData[item.id] = item;
    });

    function showDetails(id) {
        const spt = sptData[id];
        if (!spt) return;

        const html = `
            <div class="space-y-3">
                <div>
                    <label class="font-semibold text-gray-700">Nomor Bukti Penerimaan:</label>
                    <p class="text-gray-600">${spt.receipt_id}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Tahun Pajak:</label>
                    <p class="text-gray-600">${spt.tahun_pajak}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Jenis SPT:</label>
                    <p class="text-gray-600">${spt.jenis_spt}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Penghasilan:</label>
                    <p class="text-gray-600">Rp ${new Intl.NumberFormat('id-ID').format(spt.penghasilan)}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Status Verifikasi:</label>
                    <p class="text-gray-600">${spt.status_verifikasi}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Tanggal Submission:</label>
                    <p class="text-gray-600">${spt.created_at}</p>
                </div>
            </div>
        `;
        document.getElementById('detailContent').innerHTML = html;
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetails() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@endsection
