<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('kelas', $user->kelas)
            ->where('no_absen', $user->no_absen)
            ->first();

        $pembayarans = Pembayaran::where('siswa_id', $siswa?->id ?? 0)
            ->orderBy('tanggal_bayar', 'desc')
            ->paginate(15);

        return view('user.pembayaran.index', compact('pembayarans', 'siswa'));
    }
}