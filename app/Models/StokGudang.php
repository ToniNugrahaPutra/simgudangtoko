<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokGudang extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'gudang_id',
        'produk_id',
        'stok',
    ];

    protected $table = 'stok_gudang';

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
