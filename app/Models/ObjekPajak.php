<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjekPajak extends Model
{
    protected $table = 'objek_pajaks';

    // allow mass assignment for these fields
    protected $fillable = [
        'wajib_pajak_id',
        'jenis',
        'nilai_objek',
        'alamat_objek',
        // Vehicle-specific fields
        'jenis_kendaraan',
        'plat_nomor',
        'stnk_path',
        // Business-specific fields
        'nama_bisnis',
        'jenis_bisnis',
        'dokumen_usaha_path',
    ];

    // relations
    public function wajibPajak()
    {
        return $this->belongsTo(WajibPajak::class);
    }

    public function tagihanPajaks()
    {
        return $this->hasMany(TagihanPajak::class, 'objek_pajak_id');
    }
}
