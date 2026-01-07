<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor')->unique();
            $table->string('jenis_armada');
            $table->unsignedInteger('kapasitas_kg')->nullable();
            $table->string('status')->default('tersedia');
            $table->unsignedBigInteger('driver_id_current')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon');
            $table->string('email')->nullable();
            $table->string('nomor_sim')->nullable();
            $table->string('status')->default('aktif');
            $table->unsignedBigInteger('truck_id_current')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('shipment_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id')->constrained('trucks')->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->json('order_ids')->default(json_encode([]));
            $table->string('status')->default('draft');
            $table->timestamp('waktu_berangkat')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->string('admin_berangkatkan_nama')->nullable();
            $table->string('admin_selesaikan_nama')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_resi')->unique();
            $table->string('jenis_layanan');

            $table->string('pengirim_nama')->nullable();
            $table->string('pengirim_kontak_person')->nullable();
            $table->string('pengirim_telepon')->nullable();
            $table->string('pengirim_email')->nullable();
            $table->text('pengirim_alamat_pickup')->nullable();
            $table->timestamp('pengirim_jadwal_pickup')->nullable();
            $table->string('pengirim_catatan_pickup')->nullable();
            $table->string('pengirim_office_id')->nullable();

            $table->string('penerima_nama');
            $table->string('penerima_telepon');
            $table->text('penerima_alamat');
            $table->string('penerima_catatan')->nullable();

            $table->text('deskripsi_barang');
            $table->decimal('berat_kg', 10, 2);
            $table->unsignedInteger('panjang_cm')->nullable();
            $table->unsignedInteger('lebar_cm')->nullable();
            $table->unsignedInteger('tinggi_cm')->nullable();
            $table->string('jenis_armada_diminta')->nullable();
            $table->boolean('fragile')->default(false);
            $table->text('catatan_barang')->nullable();

            $table->string('status');
            $table->foreignId('truck_id')->nullable()->constrained('trucks')->nullOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->foreignId('shipment_session_id')->nullable()->constrained('shipment_sessions')->nullOnDelete();

            $table->json('qr_code_data');
            $table->string('qr_checksum')->nullable();

            $table->timestamp('tanggal_order')->nullable();
            $table->timestamps();
        });

        Schema::create('order_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('status_sebelumnya')->nullable();
            $table->string('status_baru');
            $table->text('keterangan')->nullable();
            $table->string('admin_nama')->nullable();
            $table->timestamps();
        });

        Schema::create('admin_scan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('truck_id')->constrained('trucks')->cascadeOnDelete();
            $table->foreignId('shipment_session_id')->nullable()->constrained('shipment_sessions')->nullOnDelete();
            $table->string('admin_nama')->nullable();
            $table->string('action');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_scan_logs');
        Schema::dropIfExists('order_history');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('shipment_sessions');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('trucks');
    }
};
