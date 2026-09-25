<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('kelas', $user->kelas)
            ->where('no_absen', $user->no_absen)
            ->first();

        $pembayaranSaya = Pembayaran::where('siswa_id', $siswa?->id ?? 0)
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        $totalBayar = $pembayaranSaya->where('status', 'lunas')->sum('jumlah');
        $belumBayar = $pembayaranSaya->where('status', '!=', 'lunas')->count();

        $saldoKas = Transaksi::saldo();
        $totalPemasukan = Transaksi::totalPemasukan();
        $totalPengeluaran = Transaksi::totalPengeluaran();

        return view('user.dashboard', compact(
            'siswa', 'pembayaranSaya', 'totalBayar',
            'belumBayar', 'saldoKas', 'totalPemasukan', 'totalPengeluaran'
        ));
    }
}