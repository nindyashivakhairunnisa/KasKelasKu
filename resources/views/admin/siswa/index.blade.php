@extends('layouts.admin')

@section('title', 'Daftar Siswa')

@section('content')
<div class="page-header">
    <div>
        <h1>Daftar Siswa</h1>
        <p class="subtitle">Kelola data siswa kelas</p>
    </div>
    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Siswa
    </a>
</div>

<div class="table-card">
    <div class="table-toolbar">
        <form method="GET" class="search-form">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau NIS...">
            <select name="kelas">
                <option value="">Semua Kelas</option>
                <option value="XII PPLG 1" {{ request('kelas') == 'XII PPLG 1' ? 'selected' : '' }}>XII PPLG 1</option>
            </select>
            <button type="submit" class="btn btn-sm">Cari</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>No. Absen</th>
                    <th>L/P</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $index => $siswa)
                <tr>
                    <td>{{ $siswas->firstItem() + $index }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $siswa->kelas }}</td>
                    <td>{{ $siswa->no_absen }}</td>
                    <td>{{ $siswa->jenis_kelamin }}</td>
                    <td>
                        <span class="badge badge-{{ $siswa->status === 'aktif' ? 'success' : 'secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $siswa->status)) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.siswa.edit', $siswa) }}" class="btn-icon" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon btn-danger" title="Hapus"
                                    onclick="return confirm('Yakin nonaktifkan siswa ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:2rem;">Tidak ada data siswa</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($siswas->hasPages())
    <div class="pagination">
        {{ $siswas->links() }}
    </div>
    @endif
</div>
@endsection