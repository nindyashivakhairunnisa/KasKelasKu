@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="page-header">
    <div>
        <h1>Pengaturan</h1>
        <p class="subtitle">Kelola profil dan pengguna</p>
    </div>
</div>

<!-- Profil -->
<div class="form-card">
    <h3>Profil Saya</h3>
    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.pengaturan.profile') }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Profil</button>
        </div>
    </form>
</div>

<!-- Ganti Password -->
<div class="form-card">
    <h3>Ganti Password</h3>
    <form method="POST" action="{{ route('admin.pengaturan.password') }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" name="current_password" required>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Ganti Password</button>
        </div>
    </form>
</div>

<!-- Kelola User -->
<div class="form-card">
    <h3>Tambah User Baru</h3>
    <form method="POST" action="{{ route('admin.pengaturan.createUser') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" required>
                    <option value="user">User (Siswa)</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" placeholder="XII PPLG 1">
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Tambah User</button>
        </div>
    </form>
</div>

<!-- Daftar Admin -->
<div class="table-card">
    <div class="table-header"><h3>Daftar Admin</h3></div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr><th>Nama</th><th>Email</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        @if($admin->id !== auth()->id())
                        <form action="{{ route('admin.pengaturan.deleteUser', $admin) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon btn-danger" onclick="return confirm('Hapus user ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @else
                        <span class="badge badge-success">Anda</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Daftar User -->
<div class="table-card">
    <div class="table-header"><h3>Daftar User (Siswa)</h3></div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr><th>Nama</th><th>Email</th><th>Kelas</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->kelas ?? '-' }}</td>
                    <td>
                        <form action="{{ route('admin.pengaturan.deleteUser', $user) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon btn-danger" onclick="return confirm('Hapus user ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection