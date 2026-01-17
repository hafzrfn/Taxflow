<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WajibPajak extends Model
{
    protected $fillable = ['user_id','nik','alamat','no_hp','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function objekPajaks()
    {
        return $this->hasMany(ObjekPajak::class);
    }

    public function spts()
    {
        return $this->hasMany(SPT::class);
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }
}