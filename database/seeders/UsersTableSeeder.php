<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'email' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$12$jkvwlNhWbG2WxuLdP5FoN.igEn8z/cIvg2kdnV6nzgxFsCs3UFJmG',
                'role' => 'admin',
                'office_location_id' => NULL,
                'nip' => NULL,
                'phone' => '081234567890',
                'position_id' => NULL,
                'shift_id' => NULL,
                'tanggal_masuk' => NULL,
                'status' => 'aktif',
                'foto_profile' => NULL,
                'alamat' => NULL,
                'kontak_darurat' => NULL,
                'remember_token' => NULL,
                'created_at' => '2026-02-12 13:37:16',
                'updated_at' => '2026-02-12 13:37:16',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Eka Wulan Sari',
                'email' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$12$o7GRQX5dKsF7dJLq4nWe5OS62vsV1PlXMhHZX2uWBhtXTKFBo/BvO',
                'role' => 'employee',
                'office_location_id' => NULL,
                'nip' => NULL,
                'phone' => '082123457512',
                'position_id' => 2,
                'shift_id' => 1,
                'tanggal_masuk' => NULL,
                'status' => 'aktif',
                'foto_profile' => NULL,
                'alamat' => NULL,
                'kontak_darurat' => NULL,
                'remember_token' => NULL,
                'created_at' => '2026-02-12 13:37:16',
                'updated_at' => '2026-02-12 13:37:16',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Puspita',
                'email' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$12$JWRSCxBl9HGZAcVapHoq9.wg.j0AjKkoGvNOxowLJ4JmlOYGborsa',
                'role' => 'employee',
                'office_location_id' => NULL,
                'nip' => NULL,
                'phone' => '081327627934',
                'position_id' => 3,
                'shift_id' => 1,
                'tanggal_masuk' => NULL,
                'status' => 'aktif',
                'foto_profile' => NULL,
                'alamat' => NULL,
                'kontak_darurat' => NULL,
                'remember_token' => NULL,
                'created_at' => '2026-02-12 13:37:17',
                'updated_at' => '2026-02-12 13:37:17',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Priyo Aditikno',
                'email' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$12$gSYe1tEkbmutUWpm/uVwm.6yFSqiKRBNAPPDJMyoqrP7FSf2v804G',
                'role' => 'employee',
                'office_location_id' => NULL,
                'nip' => NULL,
                'phone' => '087881805950',
                'position_id' => 4,
                'shift_id' => 1,
                'tanggal_masuk' => NULL,
                'status' => 'aktif',
                'foto_profile' => NULL,
                'alamat' => NULL,
                'kontak_darurat' => NULL,
                'remember_token' => NULL,
                'created_at' => '2026-02-12 13:37:17',
                'updated_at' => '2026-02-12 13:37:17',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Susanto',
                'email' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$12$cRfcDUTIJgQbSLK6Q8oDRuJ5FImR7hz97lbiS06esbMJVA5AAFvMa',
                'role' => 'employee',
                'office_location_id' => NULL,
                'nip' => NULL,
                'phone' => '082124823220',
                'position_id' => 5,
                'shift_id' => 1,
                'tanggal_masuk' => NULL,
                'status' => 'aktif',
                'foto_profile' => NULL,
                'alamat' => NULL,
                'kontak_darurat' => NULL,
                'remember_token' => NULL,
                'created_at' => '2026-02-12 13:37:17',
                'updated_at' => '2026-02-12 13:37:17',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Muhamat Edi',
                'email' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$12$hwjm2BVg4PeGzvLMpw.Taecxgr0Y57PQMrVVHobzdJ.L1rHJG6p7a',
                'role' => 'employee',
                'office_location_id' => NULL,
                'nip' => NULL,
                'phone' => '081585423017',
                'position_id' => 6,
                'shift_id' => 1,
                'tanggal_masuk' => NULL,
                'status' => 'aktif',
                'foto_profile' => NULL,
                'alamat' => NULL,
                'kontak_darurat' => NULL,
                'remember_token' => NULL,
                'created_at' => '2026-02-12 13:37:18',
                'updated_at' => '2026-02-12 13:37:18',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}