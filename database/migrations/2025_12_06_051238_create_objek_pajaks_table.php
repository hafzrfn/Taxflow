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
        Schema::create('objek_pajaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wajib_pajak_id')->constrained()->onDelete('cascade');
            $table->enum('jenis',['tanah','bangunan','kendaraan','usaha']);
            $table->decimal('nilai_objek', 15, 2)->default(0);
            $table->text('alamat_objek')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objek_pajaks');
    }
};
