<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Models\Kategori;
use App\Models\Toko;
use App\Models\Gudang;
use App\Models\Transaksi;

class Produk extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'nama',
        'thumbnail',
        'deskripsi',
        'harga',
        'kategori_id',
        'is_popular',
    ];

    protected $table = 'produk';

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function toko()
    {
        return $this->belongsToMany(Toko::class, 'stok_toko')
            ->withPivot('stok')
            ->withTimestamps();
    }

    public function gudang()
    {
        return $this->belongsToMany(Gudang::class, 'stok_gudang')
            ->withPivot('stok')
            ->withTimestamps();
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function getGudangProdukStok(): int
    {
        return $this->gudang()->sum('stok');
    }

    public function getTokoProdukStok(): int
    {
        return $this->toko()->sum('stok');
    }

    public function getThumbnailAttribute($value)
    {
        if (!$value) {
            return null;
        }
        return url(Storage::url($value));
    }
}
