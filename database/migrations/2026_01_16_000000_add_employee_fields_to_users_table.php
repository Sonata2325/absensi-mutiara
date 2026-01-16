<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('employee')->after('password');
            $table->string('nip')->nullable()->unique()->after('role');
            $table->string('phone')->nullable()->after('nip');
            $table->unsignedBigInteger('department_id')->nullable()->index()->after('phone');
            $table->unsignedBigInteger('shift_id')->nullable()->index()->after('department_id');
            $table->string('position')->nullable()->after('shift_id');
            $table->date('tanggal_masuk')->nullable()->after('position');
            $table->string('status')->default('aktif')->after('tanggal_masuk');
            $table->string('foto_profile')->nullable()->after('status');
            $table->text('alamat')->nullable()->after('foto_profile');
            $table->string('kontak_darurat')->nullable()->after('alamat');
            $table->softDeletes()->after('updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'role',
                'nip',
                'phone',
                'department_id',
                'shift_id',
                'position',
                'tanggal_masuk',
                'status',
                'foto_profile',
                'alamat',
                'kontak_darurat',
            ]);
        });
    }
};
