@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1>Dashboard</h1>
        <p class="subtitle">Halo, {{ auth()->user()->name }}! 👋</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">SALDO KAS KELAS</span>
            <div class="stat-icon saldo-icon"><i class="fas fa-coins"></i></div>
        </div>
        <div class="stat-value saldo-value">Rp {{ number_format($saldoKas, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">TOTAL PEMASUKAN</span>
            <div class="stat-icon pemasukan-icon"><i class="fas fa-arrow-up"></i></div>
        </div>
        <div class="stat-value pemasukan-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">TOTAL PENGELUARAN</span>
            <div class="stat-icon pengeluaran-icon"><i class="fas fa-arrow-down"></i></div>
        </div>
        <div class="stat-value pengeluaran-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">TOTAL BAYAR SAYA</span>
            <div class="stat-icon siswa-icon"><i class="fas fa-wallet"></i></div>
        </div>
        <div class="stat-value siswa-value">Rp {{ number_format($totalBayar, 0, ',', '.') }}</div>
    </div>
</div>

@if($belumBayar > 0)
<div class="alert alert-warning" style="margin-top:1.5rem;">
    <i class="fas fa-exclamation-triangle"></i>
    Anda memiliki <strong>{{ $belumBayar }}</strong> pembayaran yang belum lunas.
</div>
@endif

<div class="table-card">
    <div class="table-header">
        <h3>Riwayat Pembayaran Saya</h3>
        <a href="{{ route('user.pembayaran.index') }}" class="btn-link">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Bulan</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayaranSaya->take(5) as $p)
                <tr>
                    <td>{{ $p->tanggal_bayar->format('d M Y') }}</td>
                    <td>{{ $p->bulan }}</td>
                    <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $p->status === 'lunas' ? 'success' : ($p->status === 'terlambat' ? 'warning' : 'secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:2rem;">Belum ada riwayat pembayaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection