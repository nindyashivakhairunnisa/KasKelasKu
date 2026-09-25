@extends('layouts.admin')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="page-header">
    <div>
        <h1>Tambah Transaksi</h1>
        <p class="subtitle">Catat transaksi kas baru</p>
    </div>
    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.transaksi.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Tanggal *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label>Tipe *</label>
                <select name="tipe" required>
                    <option value="masuk" {{ old('tipe') == 'masuk' ? 'selected' : '' }}>Pemasukan (Masuk)</option>
                    <option value="keluar" {{ old('tipe') == 'keluar' ? 'selected' : '' }}>Pengeluaran (Keluar)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah (Rp) *</label>
                <input type="number" name="jumlah" value="{{ old('jumlah') }}" min="0" required>
            </div>
            <div class="form-group">
                <label>Siswa (Opsional)</label>
                <select name="siswa_id">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas as $s)
                    <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->nama }} ({{ $s->kelas }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group full-width">
                <label>Keterangan *</label>
                <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                       placeholder="Contoh: bayar kas, beli sapu, dll" required>
            </div>
            <div class="form-group full-width">
                <label>Catatan</label>
                <textarea name="catatan" rows="3">{{ old('catatan') }}</textarea>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection