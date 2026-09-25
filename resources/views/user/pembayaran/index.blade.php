@extends('layouts.user')

@section('title', 'Pembayaran Saya')

@section('content')
<div class="page-header">
    <div>
        <h1>Pembayaran Saya</h1>
        <p class="subtitle">Riwayat pembayaran kas - {{ $siswa?->nama ?? auth()->user()->name }}</p>
    </div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Bulan</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayarans as $p)
                <tr>
                    <td>{{ $p->tanggal_bayar->format('d M Y') }}</td>
                    <td>{{ $p->bulan }}</td>
                    <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $p->status === 'lunas' ? 'success' : ($p->status === 'terlambat' ? 'warning' : 'secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                        </span>
                    </td>
                    <td>{{ $p->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:2rem;">Belum ada pembayaran</td>
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