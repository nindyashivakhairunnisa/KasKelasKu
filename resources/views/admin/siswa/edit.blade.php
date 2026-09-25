@extends('layouts.admin')

@section('title', 'Edit Siswa')

@section('content')
<div class="page-header">
    <div>
        <h1>Edit Siswa</h1>
        <p class="subtitle">{{ $siswa->nama }}</p>
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

    <form method="POST" action="{{ route('admin.siswa.update', $siswa) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" required>
            </div>
            <div class="form-group">
                <label>NIS *</label>
                <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required>
            </div>
            <div class="form-group">
                <label>Kelas *</label>
                <input type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" required>
            </div>
            <div class="form-group">
                <label>No. Absen *</label>
                <input type="number" name="no_absen" value="{{ old('no_absen', $siswa->no_absen) }}" min="1" required>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin *</label>
                <select name="jenis_kelamin" required>
                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}">
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="aktif" {{ old('status', $siswa->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $siswa->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="form-group full-width">
                <label>Alamat</label>
                <textarea name="alamat" rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection