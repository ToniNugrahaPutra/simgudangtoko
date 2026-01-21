<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Kategori extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'foto',
        'tagline',
    ];

    protected $table = 'kategori';

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }

    public function getPhotoAttribute($value)
    {
        if(!$value) {
            return null;
        }
        return Storage::url($value);
    }
}
