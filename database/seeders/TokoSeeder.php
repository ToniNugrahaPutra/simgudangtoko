<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use App\Models\Toko;
use Illuminate\Database\Seeder;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $operator = Pengguna::where('email', 'operator@operator.com')->first();

        if ($operator) {
            Toko::firstOrCreate(
                ['nama' => 'Toko Cabang 1'],
                [
                    'alamat' => 'Jl. Cabang No. 1',
                    'foto' => 'toko_cabang.png',
                    'no_hp' => '021-7654321',
                    'operator_id' => $operator->id,
                ]
            );
        }
    }
}
