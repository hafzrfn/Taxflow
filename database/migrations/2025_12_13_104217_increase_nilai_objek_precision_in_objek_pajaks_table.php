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
        Schema::table('objek_pajaks', function (Blueprint $table) {
            // Change from decimal(15,2) to decimal(20,2) to support larger values
            // decimal(20,2) allows up to 18 digits before decimal point
            $table->decimal('nilai_objek', 20, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('objek_pajaks', function (Blueprint $table) {
            // Revert back to original decimal(15,2)
            $table->decimal('nilai_objek', 15, 2)->default(0)->change();
        });
    }
};
