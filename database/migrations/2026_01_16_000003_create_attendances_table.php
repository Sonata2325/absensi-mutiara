<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->decimal('lokasi_masuk_lat', 10, 7)->nullable();
            $table->decimal('lokasi_masuk_lng', 10, 7)->nullable();
            $table->decimal('lokasi_keluar_lat', 10, 7)->nullable();
            $table->decimal('lokasi_keluar_lng', 10, 7)->nullable();
            $table->string('foto_masuk')->nullable();
            $table->string('foto_keluar')->nullable();
            $table->string('status')->default('alpha');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['employee_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
