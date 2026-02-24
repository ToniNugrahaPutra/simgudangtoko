<?php

namespace Database\Seeders;

use App\Models\Gudang;
use App\Models\Produk;
use App\Models\StokToko;
use App\Models\Toko;
use Illuminate\Database\Seeder;

class StokTokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $toko = Toko::where('nama', 'Toko Cabang 1')->first();
        $gudang = Gudang::where('nama', 'Gudang Pusat')->first();
        $produk = Produk::all();

        if ($toko && $gudang) {
            foreach ($produk as $p) {
                StokToko::firstOrCreate(
                    [
                        'toko_id' => $toko->id,
                        'produk_id' => $p->id,
                    ],
                    [
                        'stok' => 50,
                        'gudang_id' => $gudang->id,
                    ]
                );
            }
        }
    }
}
