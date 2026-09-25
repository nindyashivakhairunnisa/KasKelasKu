<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['siswa', 'user']);

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        $transaksis = $query->orderBy('tanggal', 'desc')->paginate(15);

        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $siswas = Siswa::where('status', 'aktif')->orderBy('nama')->get();
        return view('admin.transaksi.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:0',
            'siswa_id' => 'nullable|exists:siswas,id',
            'catatan' => 'nullable|string',
        ]);

        Transaksi::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'tipe' => $request->tipe,
            'jumlah' => $request->jumlah,
            'siswa_id' => $request->siswa_id,
            'user_id' => Auth::id(),
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}