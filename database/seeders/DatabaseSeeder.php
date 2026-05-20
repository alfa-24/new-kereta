<?php

namespace Database\Seeders;

use App\Models\Kereta;
use App\Models\KeretaStasiun;
use App\Models\Stasiun;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'role' => 'user',
            'password' => bcrypt('password'),
        ]);

        $jakarta = Stasiun::create([
            'nama_stasiun' => 'Jakarta Gambir',
            'kota' => 'Jakarta',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
        ]);

        $bekasi = Stasiun::create([
            'nama_stasiun' => 'Bekasi',
            'kota' => 'Bekasi',
            'latitude' => -6.2336,
            'longitude' => 107.0089,
        ]);

        $cirebon = Stasiun::create([
            'nama_stasiun' => 'Cirebon',
            'kota' => 'Cirebon',
            'latitude' => -6.7326,
            'longitude' => 108.5529,
        ]);

        $bandung = Stasiun::create([
            'nama_stasiun' => 'Bandung',
            'kota' => 'Bandung',
            'latitude' => -6.9147,
            'longitude' => 107.6098,
        ]);

        $yogyakarta = Stasiun::create([
            'nama_stasiun' => 'Yogyakarta Tugu',
            'kota' => 'Yogyakarta',
            'latitude' => -7.7829,
            'longitude' => 110.3674,
        ]);

        $solo = Stasiun::create([
            'nama_stasiun' => 'Solo Balapan',
            'kota' => 'Surakarta',
            'latitude' => -7.5625,
            'longitude' => 110.8250,
        ]);

        $semarang = Stasiun::create([
            'nama_stasiun' => 'Semarang Tawang',
            'kota' => 'Semarang',
            'latitude' => -6.9680,
            'longitude' => 110.4098,
        ]);

        $surabaya = Stasiun::create([
            'nama_stasiun' => 'Surabaya Gubeng',
            'kota' => 'Surabaya',
            'latitude' => -7.2575,
            'longitude' => 112.7521,
        ]);

        $malang = Stasiun::create([
            'nama_stasiun' => 'Malang',
            'kota' => 'Malang',
            'latitude' => -7.9822,
            'longitude' => 112.6300,
        ]);

        $jember = Stasiun::create([
            'nama_stasiun' => 'Jember',
            'kota' => 'Jember',
            'latitude' => -8.1710,
            'longitude' => 113.7028,
        ]);

        $arjuna = Kereta::create(['nama_kereta' => 'Arjuna']);
        $mentari = Kereta::create(['nama_kereta' => 'Mentari']);
        $senja = Kereta::create(['nama_kereta' => 'Senja']);
        $anggrek = Kereta::create(['nama_kereta' => 'Anggrek']);
        $gajayana = Kereta::create(['nama_kereta' => 'Gajayana']);

        KeretaStasiun::create(['id_kereta' => $arjuna->id_kereta, 'id_stasiun' => $jakarta->id_stasiun, 'urutan' => 1]);
        KeretaStasiun::create(['id_kereta' => $arjuna->id_kereta, 'id_stasiun' => $semarang->id_stasiun, 'urutan' => 2]);
        KeretaStasiun::create(['id_kereta' => $arjuna->id_kereta, 'id_stasiun' => $surabaya->id_stasiun, 'urutan' => 3]);

        KeretaStasiun::create(['id_kereta' => $mentari->id_kereta, 'id_stasiun' => $jakarta->id_stasiun, 'urutan' => 1]);
        KeretaStasiun::create(['id_kereta' => $mentari->id_kereta, 'id_stasiun' => $bandung->id_stasiun, 'urutan' => 2]);
        KeretaStasiun::create(['id_kereta' => $mentari->id_kereta, 'id_stasiun' => $semarang->id_stasiun, 'urutan' => 3]);

        KeretaStasiun::create(['id_kereta' => $senja->id_kereta, 'id_stasiun' => $jakarta->id_stasiun, 'urutan' => 1]);
        KeretaStasiun::create(['id_kereta' => $senja->id_kereta, 'id_stasiun' => $cirebon->id_stasiun, 'urutan' => 2]);
        KeretaStasiun::create(['id_kereta' => $senja->id_kereta, 'id_stasiun' => $solo->id_stasiun, 'urutan' => 3]);
        KeretaStasiun::create(['id_kereta' => $senja->id_kereta, 'id_stasiun' => $surabaya->id_stasiun, 'urutan' => 4]);

        KeretaStasiun::create(['id_kereta' => $anggrek->id_kereta, 'id_stasiun' => $jakarta->id_stasiun, 'urutan' => 1]);
        KeretaStasiun::create(['id_kereta' => $anggrek->id_kereta, 'id_stasiun' => $yogyakarta->id_stasiun, 'urutan' => 2]);
        KeretaStasiun::create(['id_kereta' => $anggrek->id_kereta, 'id_stasiun' => $semarang->id_stasiun, 'urutan' => 3]);
        KeretaStasiun::create(['id_kereta' => $anggrek->id_kereta, 'id_stasiun' => $surabaya->id_stasiun, 'urutan' => 4]);

        KeretaStasiun::create(['id_kereta' => $gajayana->id_kereta, 'id_stasiun' => $jakarta->id_stasiun, 'urutan' => 1]);
        KeretaStasiun::create(['id_kereta' => $gajayana->id_kereta, 'id_stasiun' => $solo->id_stasiun, 'urutan' => 2]);
        KeretaStasiun::create(['id_kereta' => $gajayana->id_kereta, 'id_stasiun' => $malang->id_stasiun, 'urutan' => 3]);
        KeretaStasiun::create(['id_kereta' => $gajayana->id_kereta, 'id_stasiun' => $jember->id_stasiun, 'urutan' => 4]);
    }
}
