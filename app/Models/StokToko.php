<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokToko extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'toko_id',
        'produk_id',
        'stok',
        'gudang_id',
    ];
    protected $table = 'stok_toko';
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }
}
