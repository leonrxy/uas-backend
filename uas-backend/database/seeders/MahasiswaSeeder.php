<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $jurusanData = [
            'D3 Teknik Informatika',
            'D3 Farmasi D3 Unggul',
            'D3 Teknologi Hasil Pertanian',
            'D3 Agribisnis',
            'D3 Desain Komunikasi Visual',
            'D3 Bahasa Mandarin',
            'D3 Hiperkes Dan Keselamatan Kerja',
            'D4 Keselamatan Dan Kesehatan Kerja',
            'D3 Usaha Perjalanan Wisata',
            'D3 Komunikasi Terapan',
            'D3 Manajemen Administrasi',
            'D3 Perpustakaan',
            'D3 Kebidanan',
            'D3 Bahasa Inggris',
            'D3 Teknik Kimia',
            'D3 Akuntansi',
            'D3 Manajemen Pemasaran',
            'D3 Teknik Mesin',
            'D3 Teknik Sipil',
            'D3 Manajemen Perdagangan',
            'D3 Manajemen Bisnis',
            'D3 Keuangan Dan Perbankan',
            'D3 Perpajakan',
            'D4 Demografi dan Pencatatan Sipil',
            'D3 Budi Daya Ternak',
            'D3 Akuntansi PSDKU',
        ];

        foreach ($jurusanData as $jurusan) {
            DB::table('mahasiswas')->insert([
                'nama' => $faker->name,
                'nim' => 'V'.$faker->unique()->numerify('##').'22' . $faker->unique()->numerify('###'),
                'jurusan' => $jurusan,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'alamat' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
