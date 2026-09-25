@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1>Dashboard</h1>
        <p class="subtitle">Kelas XII PPLG 1 — TA 2026/2027</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">SALDO</span>
            <div class="stat-icon saldo-icon">
                <i class="fas fa-coins"></i>
            </div>
        </div>
        <div class="stat-value saldo-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">PEMASUKAN</span>
            <div class="stat-icon pemasukan-icon">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
        <div class="stat-value pemasukan-value">Rp {{ number_format($pemasukan, 0, ',', '.') }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">PENGELUARAN</span>
            <div class="stat-icon pengeluaran-icon">
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
        <div class="stat-value pengeluaran-value">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">SISWA</span>
            <div class="stat-icon siswa-icon">
                <i class="fas fa-user"></i>
            </div>
        </div>
        <div class="stat-value siswa-value">{{ $totalSiswa }}</div>
    </div>
</div>

<!-- Charts Row -->
<div class="charts-row">
    <div class="chart-card chart-large">
        <h3 class="chart-title">Pemasukan vs Pengeluaran</h3>
        <div class="chart-container">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <div class="chart-card chart-small">
        <h3 class="chart-title">Komposisi Pengeluaran</h3>
        <div class="chart-container donut-container">
            <canvas id="donutChart"></canvas>
        </div>
        <div class="chart-legend" id="donutLegend"></div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="table-card">
    <div class="table-header">
        <h3>Transaksi Terakhir</h3>
        <a href="{{ route('admin.transaksi.index') }}" class="btn-link">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>TANGGAL</th>
                    <th>KETERANGAN</th>
                    <th>TIPE</th>
                    <th style="text-align:right">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerakhir as $trx)
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
                    <td colspan="4" style="text-align:center; padding: 2rem;">
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
const chartLabels = @json($chartLabels);
const pemasukanData = @json($pemasukanBulanan);
const pengeluaranData = @json($pengeluaranBulanan);
const komposisiData = @json($komposisiPengeluaran);

// Bar Chart
const barCtx = document.getElementById('barChart').getContext('2d');
new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: chartLabels,
        datasets: [
            {
                label: 'Pemasukan',
                data: pemasukanData,
                backgroundColor: '#22c55e',
                borderRadius: 4,
                barPercentage: 0.6,
            },
            {
                label: 'Pengeluaran',
                data: pengeluaranData,
                backgroundColor: '#ef4444',
                borderRadius: 4,
                barPercentage: 0.6,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: { color: '#9ca3af', usePointStyle: true, padding: 20 }
            }
        },
        scales: {
            x: {
                grid: { color: 'rgba(255,255,255,0.05)' },
                ticks: { color: '#9ca3af' }
            },
            y: {
                grid: { color: 'rgba(255,255,255,0.05)' },
                ticks: {
                    color: '#9ca3af',
                    callback: function(value) {
                        if (value >= 1000000) return (value/1000000) + 'jt';
                        if (value >= 1000) return (value/1000) + 'rb';
                        return value;
                    }
                }
            }
        }
    }
});

// Donut Chart
const donutCtx = document.getElementById('donutChart').getContext('2d');
const donutLabels = komposisiData.map(d => d.kategori);
const donutValues = komposisiData.map(d => parseFloat(d.total));
const donutColors = ['#22c55e', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'];

new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        labels: donutLabels.length ? donutLabels : ['Kebersihan Kelas'],
        datasets: [{
            data: donutValues.length ? donutValues : [100],
            backgroundColor: donutColors,
            borderWidth: 0,
            cutout: '75%',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        }
    }
});

// Custom Legend
const legendContainer = document.getElementById('donutLegend');
if (donutLabels.length) {
    donutLabels.forEach((label, i) => {
        legendContainer.innerHTML += `
            <div class="legend-item">
                <span class="legend-color" style="background:${donutColors[i]}"></span>
                <span>${label}</span>
            </div>`;
    });
} else {
    legendContainer.innerHTML = `
        <div class="legend-item">
            <span class="legend-color" style="background:#22c55e"></span>
            <span>Kebersihan Kelas</span>
        </div>`;
}
</script>
@endsection