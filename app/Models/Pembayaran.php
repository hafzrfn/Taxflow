<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $fillable = [
        'tagihan_pajak_id',
        'user_id',
        'jumlah_bayar',
        'kode_billing',
        'status',
        'trx_id',
        'paid_at',
        'reconciled',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'reconciled' => 'boolean',
    ];

    public function tagihan()
    {
        return $this->belongsTo(TagihanPajak::class, 'tagihan_pajak_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
