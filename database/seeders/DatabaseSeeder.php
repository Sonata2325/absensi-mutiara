<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => 'password']
        );

        if (! Schema::hasTable('trucks') || ! Schema::hasTable('drivers')) {
            return;
        }

        $driver1 = Driver::firstOrCreate(
            ['telepon' => '+62812 3456 7890'],
            ['nama' => 'Ahmad Rizki', 'email' => 'ahmad@example.com', 'nomor_sim' => 'SIM-A-001', 'status' => 'aktif']
        );
        $driver2 = Driver::firstOrCreate(
            ['telepon' => '+62813 9876 5432'],
            ['nama' => 'Budi Santoso', 'email' => 'budi@example.com', 'nomor_sim' => 'SIM-A-002', 'status' => 'aktif']
        );
        $driver3 = Driver::firstOrCreate(
            ['telepon' => '+62821 1111 2222'],
            ['nama' => 'Siti Rahma', 'email' => 'siti@example.com', 'nomor_sim' => 'SIM-A-003', 'status' => 'aktif']
        );

        $truck1 = Truck::firstOrCreate(
            ['plat_nomor' => 'B 1234 CD'],
            ['jenis_armada' => 'fuso', 'kapasitas_kg' => 2000, 'status' => 'tersedia']
        );
        $truck2 = Truck::firstOrCreate(
            ['plat_nomor' => 'B 5678 EF'],
            ['jenis_armada' => 'tronton_wingbox', 'kapasitas_kg' => 8000, 'status' => 'tersedia']
        );
        $truck3 = Truck::firstOrCreate(
            ['plat_nomor' => 'B 9012 GH'],
            ['jenis_armada' => 'cdd', 'kapasitas_kg' => 1200, 'status' => 'perbaikan']
        );

        $truck1->update(['driver_id_current' => $driver1->id]);
        $driver1->update(['truck_id_current' => $truck1->id]);

        $truck2->update(['driver_id_current' => $driver2->id]);
        $driver2->update(['truck_id_current' => $truck2->id]);

        $driver3->update(['truck_id_current' => null]);
    }
}
