<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// Request validation
use App\Http\Requests\SPTRequest;

// Models
use App\Models\User;
use App\Models\WajibPajak;
use App\Models\SPT;
use App\Models\AuditLog;

class SPTController extends Controller
{
    /**
     * Submit SPT (e-Filing)
     */
    public function submit(SPTRequest $request)
    {
        // pastikan ada user ter-autentikasi
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // ambil data validasi
        $data = $request->validated();

        // ambil relasi wajibPajak, jika belum ada buat otomatis (untuk demo)
        $wajibPajak = $user->wajibPajak;
        if (!$wajibPajak) {
            $wajibPajak = WajibPajak::create([
                'user_id' => $user->id,
                // gunakan placeholder yang unik (untuk demo). Di produksi, minta user isi NIK valid.
                'nik' => 'NIK-'.now()->timestamp . '-' . $user->id,
                'no_hp' => $user->phone ?? null,
                'alamat' => $user->alamat ?? 'Belum diisi',
                'status' => 'PENDING_VERIF',
            ]);
        }

        // handle attachments kalau ada
        $filePaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('spt_attachments', 'public');
                $filePaths[] = $path;
            }
        }

        // buat SPT dalam transaksi agar atomic
        $spt = DB::transaction(function () use ($wajibPajak, $data, $filePaths, $user) {
            $spt = SPT::create([
                'wajib_pajak_id'    => $wajibPajak->id,
                'tahun_pajak'       => $data['tahun_pajak'],
                'penghasilan'       => $data['penghasilan'],
                'jenis_spt'         => $data['jenis_spt'],
                'status_verifikasi' => 'PENDING',
                'receipt_id'        => 'RCPT-' . time() . '-' . substr(md5(uniqid()), 0, 8),
            ]);

            // simpan audit log (pastikan AuditLog model punya $fillable yg sesuai)
            AuditLog::create([
                'actor' => $user->id,
                'action' => 'submit_spt',
                'payload' => json_encode(['spt_id' => $spt->id, 'files' => $filePaths]),
            ]);

            return $spt;
        });

        // redirect ke dashboard dengan flash message
        return redirect()->route('dashboard')
                         ->with('success', 'SPT submitted successfully')
                         ->with('spt_id', $spt->id)
                         ->with('receipt_id', $spt->receipt_id);
    }

    /**
     * Display list of user's SPT
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $wajibPajak = $user->wajibPajak;
        if (!$wajibPajak) {
            return redirect()->route('dashboard')->with('error', 'Anda harus mendaftar sebagai Wajib Pajak terlebih dahulu');
        }

        $spts = SPT::where('wajib_pajak_id', $wajibPajak->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('spt.index', compact('spts', 'wajibPajak'));
    }

    /**
     * Download bukti penerimaan SPT (receipt)
     */
    public function downloadReceipt(Request $request, $sptId)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $wajibPajak = $user->wajibPajak;
        if (!$wajibPajak) {
            return redirect()->route('dashboard')->with('error', 'Anda harus mendaftar sebagai Wajib Pajak terlebih dahulu');
        }

        // Cek apakah SPT milik user
        $spt = SPT::where('id', $sptId)
                   ->where('wajib_pajak_id', $wajibPajak->id)
                   ->first();

        if (!$spt) {
            return redirect()->route('spt.index')->with('error', 'SPT tidak ditemukan');
        }

        // Generate PDF content
        $pdfContent = $this->generateReceiptPdf($spt, $wajibPajak, $user);

        // Download sebagai PDF
        return response()->streamDownload(
            fn () => print($pdfContent),
            'bukti_penerimaan_spt_'.$spt->receipt_id.'.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }

    /**
     * Generate receipt PDF content
     */
    private function generateReceiptPdf($spt, $wajibPajak, $user)
    {
        // Untuk saat ini, kita generate HTML yang bisa di-print
        // Di produksi, gunakan library seperti DOMPDF atau mPDF
        
        $nama = $wajibPajak->nama ?? 'N/A';
        $npwp = $wajibPajak->npwp ?? 'N/A';
        $alamat = $wajibPajak->alamat ?? 'N/A';
        $tahunPajak = $spt->tahun_pajak;
        $jenisSpt = $spt->jenis_spt;
        $penghasilan = number_format($spt->penghasilan, 0, ',', '.');
        $statusVerifikasi = $spt->status_verifikasi;
        $receiptId = $spt->receipt_id;
        $tanggalPenerimaan = $spt->created_at->format('d/m/Y H:i:s');
        $statusClass = strtolower($statusVerifikasi === 'PENDING' ? 'pending' : ($statusVerifikasi === 'VERIFIED' ? 'verified' : 'rejected'));
        
        $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bukti Penerimaan SPT</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; }
        .section { margin: 20px 0; }
        .label { font-weight: bold; width: 150px; display: inline-block; }
        .value { display: inline-block; }
        .status { padding: 10px; border-radius: 5px; font-weight: bold; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-verified { background-color: #d4edda; color: #155724; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">BUKTI PENERIMAAN SPT ELEKTRONIK</div>
        <div>Sistem Informasi Manajemen Pajak</div>
    </div>

    <div class="section">
        <p><span class="label">Nomor Bukti:</span> <span class="value">{$receiptId}</span></p>
        <p><span class="label">Tanggal Penerimaan:</span> <span class="value">{$tanggalPenerimaan}</span></p>
    </div>

    <div class="section">
        <h3>Data Wajib Pajak</h3>
        <p><span class="label">Nama:</span> <span class="value">{$nama}</span></p>
        <p><span class="label">NPWP:</span> <span class="value">{$npwp}</span></p>
        <p><span class="label">Alamat:</span> <span class="value">{$alamat}</span></p>
    </div>

    <div class="section">
        <h3>Data SPT</h3>
        <p><span class="label">Tahun Pajak:</span> <span class="value">{$tahunPajak}</span></p>
        <p><span class="label">Jenis SPT:</span> <span class="value">{$jenisSpt}</span></p>
        <p><span class="label">Penghasilan:</span> <span class="value">Rp {$penghasilan}</span></p>
        <p><span class="label">Status Verifikasi:</span> <span class="value status status-{$statusClass}">{$statusVerifikasi}</span></p>
    </div>

    <div class="footer">
        <p>Dokumen ini adalah bukti resmi penerimaan SPT dari Sistem Informasi Manajemen Pajak</p>
        <p>Dicetak pada: {date('d/m/Y H:i:s')}</p>
    </div>
</body>
</html>
HTML;

        return $html;
    }
}
