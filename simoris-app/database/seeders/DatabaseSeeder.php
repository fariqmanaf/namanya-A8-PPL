<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserAccounts;
use App\Models\Individuals;
use App\Models\Roles;
use App\Models\SuratIzin;
use App\Models\JenisSemen;
use App\Models\StokSB;
use App\Models\StokMantri;
use App\Models\PengajuanSB;
use App\Models\LaporanIB;
use App\Models\TotalIB;
use App\Models\DataSapi;
use App\Models\Kecamatan;
use App\Models\Kabupaten;
use App\Models\Kelurahan;
use App\Models\Alamat;
use App\Models\JenisSapi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserAccounts::create([
            'name' => 'Fariq Abdhe Manaf',
            'username' => 'frqmnf',
            'email' => 'fariqmanaf24@gmail.com',
            'password' => bcrypt('password')
        ]);
    }
}
