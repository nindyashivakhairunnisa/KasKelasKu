<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $siswas = $query->orderBy('no_absen')->paginate(15);

        return view('admin.siswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|unique:siswas,nis',
            'kelas' => 'required|string',
            'no_absen' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        Siswa::create($request->all());

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|unique:siswas,nis,' . $siswa->id,
            'kelas' => 'required|string',
            'no_absen' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $siswa->update($request->all());

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->update(['status' => 'tidak_aktif']);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dinonaktifkan!');
    }
}