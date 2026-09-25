@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')
<div class="page-header">
    <div>
        <h1>Pembayaran Kas</h1>
        <p class="subtitle">Kelola pembayaran kas siswa</p>
    </div>
</div>

<!-- Form Tambah Pembayaran -->
<div class="form-card">
    <h3>Catat Pembayaran</h3>
    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.pembayaran.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Siswa *</label>
                <select name="siswa_id" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas as $s)
                    <option value="{{ $s->id }}">{{ $s->nama }} - {{ $s->kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah (Rp) *</label>
                <input type="number" name="jumlah" value="{{ old('jumlah', 5000) }}" min="0" required>
            </div>
            <div class="form-group">
                <label>Tanggal Bayar *</label>
                <input type="date" name="tanggal_bayar" value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label>Bulan *</label>
                <input type="text" name="bulan" value="{{ old('bulan', date('F Y')) }}" required>
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="lunas">Lunas</option>
                    <option value="belum_lunas">Belum Lunas</option>
                    <option value="terlambat">Terlambat</option>
                </select>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" value="{{ old('keterangan') }}">
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
        </div>
    </form>
</div>

<!-- Daftar Pembayaran -->
<div class="table-card">
    <div class="table-toolbar">
        <form method="GET" class="search-form">
            <select name="status">
                <option value="">Semua Status</option>
                <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="belum_lunas" {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
            </select>
            <button type="submit" class="btn btn-sm">Filter</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Siswa</th>
                    <th>Bulan</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayarans as $p)
                <tr>
                    <td>{{ $p->tanggal_bayar->format('d M Y') }}</td>
                    <td>{{ $p->siswa?->nama ?? '-' }}</td>
                    <td>{{ $p->bulan }}</td>
                    <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $p->status === 'lunas' ? 'success' : ($p->status === 'terlambat' ? 'warning' : 'secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.pembayaran.update', $p) }}" method="POST" style="display:inline;">
                            @csrf @method('PUT')
                            <select name="status" onchange="this.form.submit()" style="padding:4px 8px; border-radius:4px; background:#1e293b; color:#fff; border:1px solid #334155;">
                                <option value="lunas" {{ $p->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="belum_lunas" {{ $p->status == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                <option value="terlambat" {{ $p->status == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:2rem;">Belum ada pembayaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pembayarans->hasPages())
    <div class="pagination">{{ $pembayarans->links() }}</div>
    @endif
</div>
@endsection