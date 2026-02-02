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

        $employees = [
            [
                'name' => 'Eka Wulan Sari',
                'phone' => '082123457512',
                'position' => 'Accounting - Head Office Bekasi – Grand Wisata',
                'code' => 'ACC-HO-BKS'
            ],
            [
                'name' => 'Puspita',
                'phone' => '081327627934',
                'position' => 'Account Payable - Head Office Bekasi – Grand Wisata',
                'code' => 'AP-HO-BKS'
            ],
            [
                'name' => 'Priyo Aditikno',
                'phone' => '087881805950',
                'position' => 'Operation - Head Office Jakarta – Jelambar',
                'code' => 'OPS-HO-JKT'
            ],
            [
                'name' => 'Susanto',
                'phone' => '082124823220',
                'position' => 'Support Office - Head Office Bekasi – Grand Wisata & Jelambar',
                'code' => 'SUP-HO-ALL'
            ],
            [
                'name' => 'Muhamat Edi',
                'phone' => '081585423017',
                'position' => 'Support Office - Head Office Jakarta – Jelambar',
                'code' => 'SUP-HO-JKT'
            ],
        ];

        foreach ($employees as $employee) {
            $empPosition = Position::firstOrCreate(
                ['kode_posisi' => $employee['code']],
                ['nama_posisi' => $employee['position'], 'deskripsi' => $employee['position']]
            );

            User::firstOrCreate(
                ['phone' => $employee['phone']],
                [
                    'name' => $employee['name'],
                    'password' => 'password',
                    'role' => 'employee',
                    'position_id' => $empPosition->id,
                    'shift_id' => $shift->id,
                    'status' => 'aktif',
                ]
            );
        }
    }
}
