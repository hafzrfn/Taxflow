<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SPT extends Model
{
    protected $table = 'spts';

    protected $fillable = [
        'wajib_pajak_id',
        'tahun_pajak',
        'penghasilan',
        'jenis_spt',
        'status_verifikasi',
        'receipt_id',
    ];

    public function wajibPajak()
    {
        return $this->belongsTo(WajibPajak::class);
    }
}
