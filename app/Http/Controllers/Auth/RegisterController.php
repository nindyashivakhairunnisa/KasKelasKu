<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'kelas' => 'required|string',
            'no_absen' => 'required|integer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'kelas' => $request->kelas,
            'no_absen' => $request->no_absen,
        ]);

        Siswa::create([
            'nama' => $request->name,
            'nis' => 'NIS-' . str_pad($request->no_absen, 4, '0', STR_PAD_LEFT),
            'kelas' => $request->kelas,
            'no_absen' => $request->no_absen,
            'status' => 'aktif',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}