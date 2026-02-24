<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Gudang extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'alamat',
        'foto',
        'no_hp',
    ];

    protected $table = 'gudang';

    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'stok_gudang')
            ->withPivot('stok')
            ->withTimestamps();
    }
    public function getFotoAttribute($value)
    {
        if (!$value) {
            return null;
        }
        return url(Storage::url($value));
    }
}
