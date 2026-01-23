<?php

namespace Database\Seeders;

use App\Models\Position;
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
        $position = Position::firstOrCreate(
            ['kode_posisi' => 'HR'],
            ['nama_posisi' => 'Human Resource', 'deskripsi' => 'HR Position']
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
            ['phone' => '081234567890'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'role' => 'admin',
                'status' => 'aktif',
            ]
        );

        User::firstOrCreate(
            ['phone' => '089876543210'],
            [
                'name' => 'Karyawan',
                'password' => 'password',
                'role' => 'employee',
                'position_id' => $position->id,
                'shift_id' => $shift->id,
                'status' => 'aktif',
            ]
        );

        $employees = [
            ['name' => 'Andi Saputra', 'phone' => '081300000001'],
            ['name' => 'Budi Hartono', 'phone' => '081300000002'],
            ['name' => 'Citra Lestari', 'phone' => '081300000003'],
            ['name' => 'Dewi Anggraini', 'phone' => '081300000004'],
            ['name' => 'Eko Pratama', 'phone' => '081300000005'],
            ['name' => 'Fajar Hidayat', 'phone' => '081300000006'],
            ['name' => 'Gita Maharani', 'phone' => '081300000007'],
            ['name' => 'Hendra Wijaya', 'phone' => '081300000008'],
            ['name' => 'Intan Permata', 'phone' => '081300000009'],
            ['name' => 'Joko Susilo', 'phone' => '081300000010'],
        ];

        foreach ($employees as $employee) {
            User::firstOrCreate(
                ['phone' => $employee['phone']],
                [
                    'name' => $employee['name'],
                    'password' => 'password',
                    'role' => 'employee',
                    'position_id' => $position->id,
                    'shift_id' => $shift->id,
                    'status' => 'aktif',
                ]
            );
        }
    }
}
