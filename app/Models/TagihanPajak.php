<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagihanPajak extends Model
{
    protected $table = 'tagihan_pajaks';

    protected $fillable = [
        'objek_pajak_id',
        'tahun',
        'jumlah_tagihan',
        'status',
    ];

    public function objekPajak()
    {
        return $this->belongsTo(ObjekPajak::class, 'objek_pajak_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'tagihan_pajak_id');
    }
}
