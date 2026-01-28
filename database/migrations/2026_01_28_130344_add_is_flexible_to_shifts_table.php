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
        Schema::table('shifts', function (Blueprint $table) {
            $table->boolean('is_flexible')->default(false)->after('deskripsi');
            $table->time('jam_masuk')->nullable()->change();
            $table->time('jam_keluar')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropColumn('is_flexible');
            // We cannot easily revert nullable to required without data loss risk or default values, 
            // but we can try making them required again if we were strict. 
            // For now, we just drop the new column.
        });
    }
};
