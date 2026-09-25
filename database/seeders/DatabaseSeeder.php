<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin KasKelasKu',
            'email' => 'admin@kaskelasku.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Bendahara
        User::create([
            'name' => 'Bendahara Kelas',
            'email' => 'bendahara@kaskelasku.com',
            'password' => Hash::make('bendahara123'),
            'role' => 'admin',
            'kelas' => 'XII PPLG 1',
        ]);

        // Siswa & Users
        $kelas = 'XII PPLG 1';
        $namaSiswa = [
            'Ahmad Rizki', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Lestari',
            'Eko Prasetyo', 'Fitriani', 'Gunawan Hidayat', 'Hani Rahmawati',
            'Irfan Maulana', 'Jasmine Putri', 'Kevin Sanjaya', 'Lina Marlina',
            'Muhammad Fajar', 'Nadia Safitri', 'Oscar Pratama', 'Putri Ayu',
            'Qori Abdullah', 'Rina Wulandari', 'Sandiaga Uno', 'Tina Amelia',
            'Umar Bakri', 'Vina Garut', 'Wahyu Setiawan', 'Xena Warrior',
            'Yusuf Ibrahim', 'Zahra Aulia', 'Andi Wijaya'
        ];

        foreach ($namaSiswa as $index => $nama) {
            $noAbsen = $index + 1;
            $jenisKelamin = in_array($index, [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 25, 26]) ? 'P' : 'L';

            Siswa::create([
                'nama' => $nama,
                'nis' => 'NIS-' . str_pad($noAbsen, 4, '0', STR_PAD_LEFT),
                'kelas' => $kelas,
                'no_absen' => $noAbsen,
                'jenis_kelamin' => $jenisKelamin,
                'status' => 'aktif',
            ]);

            User::create([
                'name' => $nama,
                'email' => strtolower(str_replace(' ', '.', $nama)) . '@kaskelasku.com',
                'password' => Hash::make('siswa123'),
                'role' => 'user',
                'kelas' => $kelas,
                'no_absen' => $noAbsen,
            ]);
        }

        // Transaksi contoh
        $adminId = User::where('role', 'admin')->first()->id;

        // Pemasukan
        $masukData = [
            ['2026-07-30', 'bayar kas', 10000, 1],
            ['2026-07-29', 'bayar kas', 20000, 2],
            ['2026-07-29', 'fsef', 100000, 3],
            ['2026-07-29', 'bayar kas', 50000, 4],
        ];

        foreach ($masukData as $data) {
            Transaksi::create([
                'tanggal' => $data[0],
                'keterangan' => $data[1],
                'tipe' => 'masuk',
                'jumlah' => $data[2],
                'siswa_id' => $data[3],
                'user_id' => $adminId,
            ]);
        }

        // Pengeluaran
        Transaksi::create([
            'tanggal' => '2026-07-29',
            'keterangan' => 'bayar kas',
            'tipe' => 'keluar',
            'jumlah' => 10000,
            'user_id' => $adminId,
        ]);

        // Pengeluaran kategori
        Pengeluaran::create([
            'kategori' => 'Kebersihan Kelas',
            'keterangan' => 'Beli sapu & pengki',
            'jumlah' => 50000,
            'tanggal' => '2026-07-15',
            'user_id' => $adminId,
        ]);

        Pengeluaran::create([
            'kategori' => 'Dekorasi',
            'keterangan' => 'Hiasan kelas',
            'jumlah' => 75000,
            'tanggal' => '2026-07-20',
            'user_id' => $adminId,
        ]);

        // Pembayaran
        Pembayaran::create([
            'siswa_id' => 1,
            'user_id' => $adminId,
            'jumlah' => 10000,
            'tanggal_bayar' => '2026-07-30',
            'bulan' => 'Juli 2026',
            'status' => 'lunas',
        ]);

        Pembayaran::create([
            'siswa_id' => 2,
            'user_id' => $adminId,
            'jumlah' => 10000,
            'tanggal_bayar' => '2026-07-29',
            'bulan' => 'Juli 2026',
            'status' => 'lunas',
        ]);
    }
}