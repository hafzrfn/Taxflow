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
        Schema::create('tagihan_pajaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objek_pajak_id')->constrained()->onDelete('cascade');
            $table->integer('tahun');
            $table->decimal('jumlah_tagihan', 15, 2);
            $table->enum('status',['BELUM_LUNAS','PAYMENT_INITIATED','LUNAS'])->default('BELUM_LUNAS');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_pajaks');
    }
};
