<?php

namespace Database\Seeders;

use App\Models\Gudang;
use Illuminate\Database\Seeder;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gudang::firstOrCreate(
            ['nama' => 'Gudang Pusat'],
            [
                'alamat' => 'Jl. Pusat Logistik No. 1',
                'foto' => 'gudang_pusat.png',
                'no_hp' => '021-1234567',
            ]
        );
    }
}
