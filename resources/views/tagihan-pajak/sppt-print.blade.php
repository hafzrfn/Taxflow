<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>SPPT - Surat Pemberitahuan Pajak Tahunan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: white;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #333;
            padding: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .header-subtitle {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            background: #f0f0f0;
            padding: 8px 10px;
            margin-bottom: 10px;
            border-left: 4px solid #333;
        }

        .row {
            display: flex;
            margin-bottom: 8px;
        }

        .label {
            width: 40%;
            font-weight: bold;
            color: #333;
        }

        .value {
            width: 60%;
            color: #555;
        }

        .box {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            background: #fafafa;
        }

        .amount-box {
            border: 2px solid #d32f2f;
            padding: 15px;
            margin: 20px 0;
            background: #ffebee;
        }

        .amount-label {
            font-size: 12px;
            color: #666;
        }

        .amount-value {
            font-size: 28px;
            font-weight: bold;
            color: #d32f2f;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature {
            text-align: center;
            width: 45%;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 5px;
            font-size: 12px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #999;
            border-top: 1px solid #ccc;
            padding-top: 15px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                border: none;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-title">SURAT PEMBERITAHUAN PAJAK TAHUNAN (SPPT)</div>
            <div class="header-subtitle">PAJAK BUMI DAN BANGUNAN</div>
            <div class="header-subtitle">Sistem Informasi Manajemen Pajak</div>
        </div>

        <!-- Detail Objek Pajak -->
        <div class="section">
            <div class="section-title">DATA OBJEK PAJAK</div>
            <div class="box">
                <div class="row">
                    <div class="label">Jenis Objek Pajak</div>
                    <div class="value">: {{ $tagihan->objekPajak->jenis }}</div>
                </div>
                <div class="row">
                    <div class="label">Alamat Objek</div>
                    <div class="value">: {{ $tagihan->objekPajak->alamat_objek }}</div>
                </div>
                <div class="row">
                    <div class="label">Nilai Jual Objek Pajak (NJOP)</div>
                    <div class="value">: Rp {{ number_format($tagihan->objekPajak->nilai_objek, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Detail Wajib Pajak -->
        <div class="section">
            <div class="section-title">DATA WAJIB PAJAK</div>
            <div class="box">
                <div class="row">
                    <div class="label">Nama Lengkap</div>
                    <div class="value">: {{ $wajibPajak->user->name ?? $user->name ?? 'N/A' }}</div>
                </div>
                <div class="row">
                    <div class="label">NIK</div>
                    <div class="value">: {{ $wajibPajak->nik ?? 'N/A' }}</div>
                </div>
                <div class="row">
                    <div class="label">Alamat Wajib Pajak</div>
                    <div class="value">: {{ $wajibPajak->alamat ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Detail Tagihan -->
        <div class="section">
            <div class="section-title">PERHITUNGAN PAJAK</div>
            <div class="box">
                <div class="row">
                    <div class="label">Tahun Pajak</div>
                    <div class="value">: {{ $tagihan->tahun }}</div>
                </div>
                <div class="row">
                    <div class="label">Nilai Pengurangan</div>
                    <div class="value">: Rp 0</div>
                </div>
                <div class="row">
                    <div class="label">Nilai Objek Pajak Kena Pajak (NOPKP)</div>
                    <div class="value">: Rp {{ number_format($tagihan->objekPajak->nilai_objek, 0, ',', '.') }}</div>
                </div>
                <div class="row">
                    <div class="label">Tarif Pajak</div>
                    <div class="value">: 0,5%</div>
                </div>
            </div>
        </div>

        <!-- Jumlah Tagihan -->
        <div class="amount-box">
            <div class="amount-label">JUMLAH POKOK PAJAK</div>
            <div class="amount-value">Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</div>
        </div>

        <!-- Status & Jatuh Tempo -->
        <div class="section">
            <div class="section-title">INFORMASI PEMBAYARAN</div>
            <div class="box">
                <div class="row">
                    <div class="label">Status</div>
                    <div class="value">: {{ $tagihan->status }}</div>
                </div>
                <div class="row">
                    <div class="label">Jatuh Tempo</div>
                    <div class="value">: 31 Desember {{ $tagihan->tahun }}</div>
                </div>
                <div class="row">
                    <div class="label">Tanggal Pemberitahuan</div>
                    <div class="value">: {{ now()->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature">
                <p style="font-size: 12px; margin-bottom: 50px;">Wajib Pajak</p>
                <div class="signature-line">
                    {{ $wajibPajak->user->name ?? $user->name ?? 'N/A' }}
                </div>
            </div>
            <div class="signature">
                <p style="font-size: 12px; margin-bottom: 50px;">Kepala Dinas Pajak</p>
                <div class="signature-line">
                    _________________
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Surat ini adalah bukti resmi pemberitahuan pajak dari Sistem Informasi Manajemen Pajak</p>
            <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>No. Dokumen: SPPT-{{ $tagihan->id }}-{{ $tagihan->tahun }}</p>
        </div>
    </div>
</body>

</html>