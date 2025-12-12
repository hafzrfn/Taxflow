<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('objek_pajaks', function (Blueprint $table) {
            // Vehicle-specific fields
            $table->string('jenis_kendaraan')->nullable()->after('jenis');
            $table->string('plat_nomor')->nullable()->after('jenis_kendaraan');
            $table->string('stnk_path')->nullable()->after('plat_nomor');

            // Business-specific fields
            $table->string('nama_bisnis')->nullable()->after('stnk_path');
            $table->string('jenis_bisnis')->nullable()->after('nama_bisnis');
            $table->string('dokumen_usaha_path')->nullable()->after('jenis_bisnis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('objek_pajaks', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kendaraan',
                'plat_nomor',
                'stnk_path',
                'nama_bisnis',
                'jenis_bisnis',
                'dokumen_usaha_path'
            ]);
        });
    }
};
