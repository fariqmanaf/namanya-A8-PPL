<?php

// namespace Database\Factories;

// use Illuminate\Database\Eloquent\Factories\Factory;
// use App\Models\UserAccounts;
// use App\Models\Individuals;
// use App\Models\Roles;
// use App\Models\SuratIzin;
// use App\Models\JenisSemen;
// use App\Models\StokSB;
// use App\Models\StokMantri;
// use App\Models\PengajuanSB;
// use App\Models\LaporanIB;
// use App\Models\TotalIB;
// use App\Models\DataSapi;
// use App\Models\Kecamatan;
// use App\Models\Kabupaten;
// use App\Models\Kelurahan;
// use App\Models\Alamat;
// use App\Models\JenisSapi;
// use Faker\Factory as Faker;

// /**
//  * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAccount>
//  */
// class UserAccountsFactory extends Factory
// {
//     protected $model = UserAccounts::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'id_individual' => Individuals::factory(),
//             'username' => $faker->unique()->userName,
//             'password' => $faker->password,
//             'id_roles' => Roles::factory(),
//         ];
//     }
// }

// class IndividualsFactory extends Factory
// {
//     protected $model = Individuals::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'nik' => $faker->unique()->nik,
//             'name' => $faker->name,
//             'tgl_lahir' => $faker->dateTimeBetween('-60 years', '-18 years'),
//             'no_telp' => $faker->phoneNumber,
//             'id_alamat' => Alamat::factory(),
//         ];
//     }
// }

// class RolesFactory extends Factory
// {
//     protected $model = Roles::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'role_name' => $faker->randomElement(['Admin', 'Mantri', 'Peternak']),
//         ];
//     }
// }

// class SuratIzinFactory extends Factory
// {
//     protected $model = SuratIzin::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'nomor_surat' => $faker->unique()->randomNumber(6),
//             'bukti' => $faker->binary('image/jpeg', 100, 100),
//             'is_accepted' => $faker->boolean,
//             'id_mantri' => Individuals::factory(),
//         ];
//     }
// }

// class JenisSemenFactory extends Factory
// {
//     protected $model = JenisSemen::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'jenis_semen' => $faker->randomElement(['Sapi Limosin', 'Sapi Brahman', 'Sapi Simmental', 'Sapi Friesian']),
//         ];
//     }
// }

// class StokSBFactory extends Factory
// {
//     protected $model = StokSB::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'id_kecamatan' => Kecamatan::factory(),
//             'id_jenis' => JenisSemen::factory(),
//             'jumlah' => $faker->numberBetween(100, 500),
//             'used' => $faker->numberBetween(0, 100),
//         ];
//     }
// }

// class StokMantriFactory extends Factory
// {
//     protected $model = StokMantri::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'id_mantri' => Individuals::factory(),
//             'id_semen' => JenisSemen::factory(),
//             'total' => $faker->numberBetween(50, 200),
//             'used' => $faker->numberBetween(0, 50),
//         ];
//     }
// }

// class PengajuanSBFactory extends Factory
// {
//     protected $model = PengajuanSB::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'id_mantri' => Individuals::factory(),
//             'id_jenis' => JenisSemen::factory(),
//             'jumlah' => $faker->numberBetween(10, 50),
//             'is_taken' => $faker->boolean,
//             'tanggal' => $faker->dateTimeBetween('-1 month', '+1 month'),
//         ];
//     }
// }

// class LaporanIBFactory extends Factory
// {
//     protected $model = LaporanIB::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'id_sapi' => DataSapi::factory(),
//             'kode_pejantan' => $faker->unique()->randomNumber(6),
//             'kode_pembuatan' => $faker->unique()->randomNumber(6),
//             'status_bunting' => $faker->boolean,
//             'id_peternak' => Individuals::factory(),
//             'id_mantri' => Individuals::factory(),
//         ];
//     }
// }

// class TotalIBFactory extends Factory
// {
//     protected $model = TotalIB::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'id_laporan' => LaporanIB::factory(),
//             'id_semen' => JenisSemen::factory(),
//             'tgl_ib' => $faker->dateTimeBetween('-1 month', '+1 month'),
//         ];
//     }
// }

// class DataSapiFactory extends Factory
// {
//     protected $model = DataSapi::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'id_jenis' => JenisSapi::factory(),
//             'id_peternak' => Individuals::factory(),
//             'detail' => $faker->paragraph,
//         ];
//     }
// }

// class KecamatanFactory extends Factory
// {
//     protected $model = Kecamatan::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'kecamatan' => $faker->city,
//         ];
//     }
// }

// class KabupatenFactory extends Factory
// {
//     protected $model = Kabupaten::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'kabupaten' => $faker->city,
//         ];
//     }
// }

// class KelurahanFactory extends Factory
// {
//     protected $model = Kelurahan::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'kelurahan' => $faker->streetName,
//         ];
//     }
// }

// class AlamatFactory extends Factory
// {
//     protected $model = Alamat::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'id_kabupaten' => Kabupaten::factory(),
//             'id_kecamatan' => Kecamatan::factory(),
//             'id_kelurahan' => Kelurahan::factory(),
//             'detail' => $faker->streetAddress,
//         ];
//     }
// }

// class JenisSapiFactory extends Factory
// {
//     protected $model = JenisSapi::class;

//     public function definition(): array
//     {
//         $faker = Faker::create('id_ID');
//         return [
//             'jenis' => $faker->randomElement(['Sapi Perah', 'Sapi Potong']),
//         ];
//     }
// }