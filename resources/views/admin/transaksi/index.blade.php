@extends('layouts.admin')

@section('title', 'Transaksi Kas')

@section('content')
<div class="page-header">
    <div>
        <h1>Transaksi Kas</h1>
        <p class="subtitle">Kelola semua transaksi kas kelas</p>
    </div>
    <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Transaksi
    </a>
</div>

<div class="table-card">
    <div class="table-toolbar">
        <form method="GET" class="search-form">
            <select name="tipe">
                <option value="">Semua Tipe</option>
                <option value="masuk" {{ request('tipe') == 'masuk' ? 'selected' : '' }}>Pemasukan</option>
                <option value="keluar" {{ request('tipe') == 'keluar' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
            <button type="submit" class="btn btn-sm">Filter</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Siswa</th>
                    <th>Tipe</th>
                    <th style="text-align:right">Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $trx)
                <tr>
                    <td>{{ $trx->tanggal->format('d M Y') }}</td>
                    <td>{{ $trx->keterangan }}</td>
                    <td>{{ $trx->siswa?->nama ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $trx->tipe === 'masuk' ? 'success' : 'danger' }}">
                            {{ ucfirst($trx->tipe) }}
                        </span>
                    </td>
                    <td style="text-align:right" class="{{ $trx->tipe === 'masuk' ? 'text-success' : 'text-danger' }}">
                        {{ $trx->tipe === 'masuk' ? '+' : '-' }}Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                    </td>
                    <td>
                        <form action="{{ route('admin.transaksi.destroy', $trx) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon btn-danger"
                                    onclick="return confirm('Hapus transaksi ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:2rem;">Tidak ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transaksis->hasPages())
    <div class="pagination">{{ $transaksis->links() }}</div>
    @endif
</div>
@endsection