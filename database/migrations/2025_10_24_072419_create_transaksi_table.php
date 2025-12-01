<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan')->index();
            $table->string('no_hp')->index();
            $table->unsignedInteger('sub_total');
            $table->unsignedInteger('pajak');
            $table->unsignedInteger('total_bayar')->index();
            $table->foreignId('toko_id')->constrained('toko')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
