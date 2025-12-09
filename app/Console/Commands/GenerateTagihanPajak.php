<?php

namespace App\Console\Commands;

use App\Models\ObjekPajak;
use App\Models\TagihanPajak;
use Illuminate\Console\Command;

class GenerateTagihanPajak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pajak:generate-tagihan {--tahun=} {--bulan=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate tagihan pajak tahunan/bulanan secara otomatis untuk semua objek pajak';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tahun = $this->option('tahun') ?? now()->year;
        $bulan = $this->option('bulan'); // opsional untuk pajak bulanan

        // Ambil semua objek pajak
        $objekPajaks = ObjekPajak::all();

        if ($objekPajaks->isEmpty()) {
            $this->info('Tidak ada objek pajak yang terdaftar.');
            return;
        }

        $count = 0;
        foreach ($objekPajaks as $objek) {
            // Cek apakah tagihan sudah ada untuk tahun ini
            $existingTagihan = TagihanPajak::where('objek_pajak_id', $objek->id)
                                            ->where('tahun', $tahun)
                                            ->exists();

            if ($existingTagihan) {
                $this->warn("Tagihan untuk {$objek->jenis} tahun {$tahun} sudah ada. Dilewati.");
                continue;
            }

            // Calculate tagihan berdasarkan NJOP
            // Rumus: NJOP * tarif pajak (default 0.5% untuk PBB, bisa dikustomisasi)
            $tarifPajak = 0.005; // 0.5%
            $jumlahTagihan = $objek->nilai_objek * $tarifPajak;

            // Buat tagihan baru
            $tagihan = TagihanPajak::create([
                'objek_pajak_id' => $objek->id,
                'tahun' => $tahun,
                'jumlah_tagihan' => $jumlahTagihan,
                'status' => 'BELUM_LUNAS',
            ]);

            $count++;
            $this->info("✓ Tagihan dibuat: {$objek->jenis} tahun {$tahun} - Rp " . number_format($jumlahTagihan, 0, ',', '.'));
        }

        $this->info("\n{$count} tagihan berhasil dibuat untuk tahun {$tahun}");
    }
}
