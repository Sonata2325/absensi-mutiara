<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Setting;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $department = Department::firstOrCreate(
            ['kode_department' => 'HR'],
            ['nama_department' => 'Human Resource', 'deskripsi' => 'HR Department']
        );

        $shift = Shift::firstOrCreate(
            ['nama_shift' => 'Pagi'],
            [
                'jam_masuk' => '08:00',
                'jam_keluar' => '16:00',
                'toleransi_terlambat' => 10,
                'deskripsi' => 'Shift pagi',
                'is_active' => true,
            ]
        );

        Setting::setValue('work_start_time', '08:00');
        Setting::setValue('work_end_time', '17:00');
        Setting::setValue('late_tolerance_minutes', '10');
        Setting::setValue('office_radius_meters', '200');

        User::firstOrCreate(
            ['email' => 'admin@absensi.test'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'role' => 'admin',
                'status' => 'aktif',
            ]
        );

        User::firstOrCreate(
            ['email' => 'karyawan@absensi.test'],
            [
                'name' => 'Karyawan',
                'password' => 'password',
                'role' => 'employee',
                'nip' => 'EMP001',
                'department_id' => $department->id,
                'shift_id' => $shift->id,
                'status' => 'aktif',
            ]
        );
    }
}
