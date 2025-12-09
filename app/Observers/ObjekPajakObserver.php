<?php

namespace App\Observers;

use App\Models\ObjekPajak;
use App\Models\TagihanPajak;
use Illuminate\Support\Facades\Log;

class ObjekPajakObserver
{
    /**
     * Handle the ObjekPajak "created" event.
     * Secara otomatis membuat TagihanPajak untuk tahun berjalan.
     */
    public function created(ObjekPajak $objekPajak): void
    {
        try {
            $tahunBerjalan = date('Y');
            
            // Cek apakah tagihan sudah ada untuk tahun ini
            $existingTagihan = TagihanPajak::where('objek_pajak_id', $objekPajak->id)
                ->where('tahun', $tahunBerjalan)
                ->first();
            
            if ($existingTagihan) {
                Log::info("Tagihan untuk ObjekPajak ID {$objekPajak->id} tahun {$tahunBerjalan} sudah ada.");
                return;
            }
            
            // Hitung jumlah tagihan: nilai_objek * 0.5% (tarif PBB)
            $jumlahTagihan = $objekPajak->nilai_objek * 0.005;
            
            // Buat tagihan baru
            TagihanPajak::create([
                'objek_pajak_id' => $objekPajak->id,
                'tahun' => $tahunBerjalan,
                'jumlah_tagihan' => $jumlahTagihan,
                'status' => 'BELUM_LUNAS',
            ]);
            
            Log::info("Tagihan otomatis dibuat untuk ObjekPajak ID {$objekPajak->id}, Tahun {$tahunBerjalan}, Jumlah: Rp {$jumlahTagihan}");
        } catch (\Exception $e) {
            Log::error("Error saat membuat tagihan otomatis untuk ObjekPajak ID {$objekPajak->id}: {$e->getMessage()}");
        }
    }

    /**
     * Handle the ObjekPajak "updated" event.
     */
    public function updated(ObjekPajak $objekPajak): void
    {
        //
    }

    /**
     * Handle the ObjekPajak "deleted" event.
     */
    public function deleted(ObjekPajak $objekPajak): void
    {
        //
    }

    /**
     * Handle the ObjekPajak "restored" event.
     */
    public function restored(ObjekPajak $objekPajak): void
    {
        //
    }

    /**
     * Handle the ObjekPajak "force deleted" event.
     */
    public function forceDeleted(ObjekPajak $objekPajak): void
    {
        //
    }
}
