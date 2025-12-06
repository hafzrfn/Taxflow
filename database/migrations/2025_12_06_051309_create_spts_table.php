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
        Schema::create('spts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wajib_pajak_id')->constrained()->onDelete('cascade');
            $table->integer('tahun_pajak');
            $table->decimal('penghasilan', 15,2)->default(0);
            $table->enum('jenis_spt', ['TAHUNAN','BULANAN']);
            $table->enum('status_verifikasi', ['PENDING','VERIFIED','REJECTED'])->default('PENDING');
            $table->string('receipt_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spts');
    }
};
