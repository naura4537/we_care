<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Kosongkan tabel users sebelum diisi
        DB::table('users')->truncate();
        
        DB::table('users')->insert([
            // User 1 (Admin)
            [
                'id' => 1,
                'nama' => 'james',
                'email' => 'namanyajames@gmail.com',
                'password' => Hash::make('password'), // Ganti MD5 dengan Hash
                'role' => 'admin',
                'no_telp' => '08155628275',
                'tanggal_lahir' => '2000-11-10',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jln Idjen, no 123, Kec Klojen Kota Malang',
            ],
            // User 2 (Dokter)
            [
                'id' => 2,
                'nama' => 'Dr. Budi Santoso',
                'email' => 'budi@wecare.com',
                'password' => Hash::make('password'),
                'role' => 'dokter',
                'no_telp' => '081234567890',
                'tanggal_lahir' => null,
                'jenis_kelamin' => null,
                'alamat' => null,
            ],
            // User 3 (Admin)
            [
                'id' => 3,
                'nama' => 'James',
                'email' => 'adminwecare@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'no_telp' => '082345678901',
                'tanggal_lahir' => '2004-09-28',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl Bali No 99B Malang',
            ],
            // User 4 (Pasien)
            [
                'id' => 4,
                'nama' => 'Pasien 1',
                'email' => 'pasien1@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'pasien',
                'no_telp' => '08111111111',
                'tanggal_lahir' => null,
                'jenis_kelamin' => null,
                'alamat' => null,
            ],
            // User 5 (Pasien)
            [
                'id' => 5,
                'nama' => 'Pasien 2',
                'email' => 'pasien2@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'pasien',
                'no_telp' => '08111111112',
                'tanggal_lahir' => null,
                'jenis_kelamin' => null,
                'alamat' => null,
            ],
            
            // ... (DAN SETERUSNYA SAMPAI 43 USERS) ...
            
        ]);
    }
}