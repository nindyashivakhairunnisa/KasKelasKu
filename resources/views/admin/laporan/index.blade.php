@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="page-header">
    <div>
        <h1>Laporan Keuangan</h1>
        <p class="subtitle">Laporan transaksi kas kelas</p>
    </div>
</div>

<!-- Filter -->
<div class="form-card">
    <form method="GET" class="filter-form">
        <div class="form-row">
            <div class="form-group">
                <label>Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" value="{{ $tanggalMulai }}">
            </div>
            <div class="form-group">
                <label>Sampai Tanggal</label>
                <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
            </div>
            <div class="form-group" style="align-self:flex-end;">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">TOTAL PEMASUKAN</span>
            <div class="stat-icon pemasukan-icon"><i class="fas fa-arrow-up"></i></div>
        </div>
        <div class="stat-value pemasukan-value">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">TOTAL PENGELUARAN</span>
            <div class="stat-icon pengeluaran-icon"><i class="fas fa-arrow-down"></i></div>
        </div>
        <div class="stat-value pengeluaran-value">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">SALDO</span>
            <div class="stat-icon saldo-icon"><i class="fas fa-coins"></i></div>
        </div>
        <div class="stat-value saldo-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
    </div>
</div>

<!-- Detail Transaksi -->
<div class="table-card">
    <div class="table-header">
        <h3>Detail Transaksi</h3>
        <a href="{{ route('admin.laporan.export', request()->query()) }}" class="btn btn-sm">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Tipe</th>
                    <th style="text-align:right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $trx)
                <tr>
                    <td>{{ $trx->tanggal->format('d M Y') }}</td>
                    <td>{{ $trx->keterangan }}</td>
                    <td>
                        <span class="badge badge-{{ $trx->tipe === 'masuk' ? 'success' : 'danger' }}">
                            {{ ucfirst($trx->tipe) }}
                        </span>
                    </td>
                    <td style="text-align:right" class="{{ $trx->tipe === 'masuk' ? 'text-success' : 'text-danger' }}">
                        {{ $trx->tipe === 'masuk' ? '+' : '-' }}Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:2rem;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection