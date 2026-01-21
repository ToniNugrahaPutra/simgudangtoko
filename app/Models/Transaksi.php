<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
         use SoftDeletes;

    protected $fillable = [
        'nama_pelanggan',
        'no_hp',
        'sub_total',
        'pajak',
        'total_bayar',
        'toko_id',
    ];
    protected $table = 'transaksi';
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
