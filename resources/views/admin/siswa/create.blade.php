@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('content')
<div class="page-header">
    <div>
        <h1>Tambah Siswa</h1>
        <p class="subtitle">Tambahkan data siswa baru</p>
    </div>
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
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

    <form method="POST" action="{{ route('admin.siswa.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required>
            </div>
            <div class="form-group">
                <label>NIS *</label>
                <input type="text" name="nis" value="{{ old('nis') }}" required>
            </div>
            <div class="form-group">
                <label>Kelas *</label>
                <input type="text" name="kelas" value="{{ old('kelas', 'XII PPLG 1') }}" required>
            </div>
            <div class="form-group">
                <label>No. Absen *</label>
                <input type="number" name="no_absen" value="{{ old('no_absen') }}" min="1" required>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin *</label>
                <select name="jenis_kelamin" required>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}">
            </div>
            <div class="form-group full-width">
                <label>Alamat</label>
                <textarea name="alamat" rows="3">{{ old('alamat') }}</textarea>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection