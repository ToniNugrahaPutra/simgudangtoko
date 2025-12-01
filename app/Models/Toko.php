<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Toko extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'alamat',
        'foto',
        'no_hp',
        'operator_id',
    ];

    public function operator()
    {
        return $this->belongsTo(Pengguna::class, 'operator_id');
    }

    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'stok_toko')
            ->withPivot('stok')
            ->withPivot('gudang_id')
            ->withTimestamps();
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function getFotoAttribute($value)
    {
        if(!$value) {
            return null;
        }
        return Storage::url($value);
    }
}
