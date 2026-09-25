<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['siswa', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        $pembayarans = $query->orderBy('tanggal_bayar', 'desc')->paginate(15);
        $siswas = Siswa::where('status', 'aktif')->orderBy('nama')->get();

        return view('admin.pembayaran.index', compact('pembayarans', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'bulan' => 'required|string',
            'status' => 'required|in:lunas,belum_lunas,terlambat',
            'keterangan' => 'nullable|string',
        ]);

        Pembayaran::create([
            'siswa_id' => $request->siswa_id,
            'user_id' => Auth::id(),
            'jumlah' => $request->jumlah,
            'tanggal_bayar' => $request->tanggal_bayar,
            'bulan' => $request->bulan,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->status === 'lunas') {
            Transaksi::create([
                'tanggal' => $request->tanggal_bayar,
                'keterangan' => 'Pembayaran kas - ' . $request->bulan,
                'tipe' => 'masuk',
                'jumlah' => $request->jumlah,
                'siswa_id' => $request->siswa_id,
                'user_id' => Auth::id(),
            ]);
        }

        return back()->with('success', 'Pembayaran berhasil dicatat!');
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:lunas,belum_lunas,terlambat',
        ]);

        $pembayaran->update(['status' => $request->status]);

        return back()->with('success', 'Status pembayaran diperbarui!');
    }
}