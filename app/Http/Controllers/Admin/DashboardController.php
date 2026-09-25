<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Siswa;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $saldo = Transaksi::saldo();
        $pemasukan = Transaksi::totalPemasukan();
        $pengeluaran = Transaksi::totalPengeluaran();
        $totalSiswa = Siswa::where('status', 'aktif')->count();

        $transaksiTerakhir = Transaksi::with('siswa')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $pemasukanBulanan = [];
        $pengeluaranBulanan = [];

        for ($i = 1; $i <= 12; $i++) {
            $pemasukanBulanan[] = Transaksi::where('tipe', 'masuk')
                ->whereMonth('tanggal', $i)
                ->whereYear('tanggal', date('Y'))
                ->sum('jumlah');

            $pengeluaranBulanan[] = Transaksi::where('tipe', 'keluar')
                ->whereMonth('tanggal', $i)
                ->whereYear('tanggal', date('Y'))
                ->sum('jumlah');
        }

        $komposisiPengeluaran = Pengeluaran::byKategori();

        return view('admin.dashboard', compact(
            'saldo', 'pemasukan', 'pengeluaran', 'totalSiswa',
            'transaksiTerakhir', 'chartLabels',
            'pemasukanBulanan', 'pengeluaranBulanan',
            'komposisiPengeluaran'
        ));
    }
}