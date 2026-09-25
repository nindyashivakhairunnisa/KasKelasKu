<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', date('Y-m-01'));
        $tanggalAkhir = $request->input('tanggal_akhir', date('Y-m-d'));

        $transaksis = Transaksi::with(['siswa', 'user'])
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalMasuk = $transaksis->where('tipe', 'masuk')->sum('jumlah');
        $totalKeluar = $transaksis->where('tipe', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        $pengeluarans = Pengeluaran::whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])->get();
        $pembayarans = Pembayaran::with('siswa')
            ->whereBetween('tanggal_bayar', [$tanggalMulai, $tanggalAkhir])
            ->get();

        return view('admin.laporan.index', compact(
            'transaksis', 'totalMasuk', 'totalKeluar', 'saldo',
            'pengeluarans', 'pembayarans', 'tanggalMulai', 'tanggalAkhir'
        ));
    }

    public function exportPdf(Request $request)
    {
        return back()->with('info', 'Fitur export PDF akan segera tersedia.');
    }
}