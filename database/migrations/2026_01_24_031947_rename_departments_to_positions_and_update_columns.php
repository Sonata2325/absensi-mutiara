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
        Schema::rename('departments', 'positions');

        Schema::table('positions', function (Blueprint $table) {
            $table->renameColumn('nama_department', 'nama_posisi');
            $table->renameColumn('kode_department', 'kode_posisi');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('department_id', 'position_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('position_id', 'department_id');
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->renameColumn('nama_posisi', 'nama_department');
            $table->renameColumn('kode_posisi', 'kode_department');
        });

        Schema::rename('positions', 'departments');
    }
};
