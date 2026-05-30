@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

@php
    $totalTransaksi = $transaksiMenunggu + $transaksiBatch + $transaksiJemput + $transaksiSelesai;
@endphp

<div class="d-flex flex-column gap-4">

    {{-- ============ PAGE HEADER ============ --}}
    <div class="page-header-row">
        <div>
            <h1 class="page-header-title">Dashboard</h1>
            <p class="page-header-subtitle">Selamat datang kembali, {{ auth('admin')->user()->nama }}.</p>
        </div>
        @if($transaksiMenunggu > 0)
        <a href="{{ route('admin.transaksi.index') }}" class="page-header-pill text-decoration-none">
            <span class="dot"></span>
            <span class="count">{{ $transaksiMenunggu }}</span> menunggu tindak lanjut
            <i class="bi bi-arrow-right" style="font-size: 0.75rem;"></i>
        </a>
        @endif
    </div>

    {{-- ============ KPI ROW (4 cards, monochrome, big numbers) ============ --}}
    <div class="row g-3">
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <div class="kpi-card-header">
                    <span class="kpi-label">Total Penjemputan</span>
                    <i class="kpi-icon bi bi-box-seam"></i>
                </div>
                <div class="kpi-value">{{ $totalTransaksi }}</div>
                <div class="kpi-sub">
                    <span class="delta-up">{{ $transaksiSelesai }} selesai</span>
                    &middot; {{ $transaksiMenunggu + $transaksiBatch + $transaksiJemput }} aktif
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <div class="kpi-card-header">
                    <span class="kpi-label">Total Users</span>
                    <i class="kpi-icon bi bi-people"></i>
                </div>
                <div class="kpi-value">{{ $totalUsers }}</div>
                <div class="kpi-sub">Pengguna terdaftar</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <div class="kpi-card-header">
                    <span class="kpi-label">Total Petugas</span>
                    <i class="kpi-icon bi bi-person-badge"></i>
                </div>
                <div class="kpi-value">{{ $totalPetugas }}</div>
                <div class="kpi-sub">Tim lapangan aktif</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <div class="kpi-card-header">
                    <span class="kpi-label">Total Trucks</span>
                    <i class="kpi-icon bi bi-truck"></i>
                </div>
                <div class="kpi-value">{{ $totalTrucks }}</div>
                <div class="kpi-sub">
                    <span class="delta-up">{{ $truckIdle }} tersedia</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ ANALYTICS ROW (2/3 + 1/3 split) ============ --}}
    <div class="row g-3">

        {{-- LEFT 2/3: Recent activity table --}}
        <div class="col-lg-8">
            <div class="card activity-card rounded-3 h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title">
                        <i class="bi bi-truck"></i> Penjemputan Sedang Berlangsung
                    </h5>
                    <a href="{{ route('admin.transaksi.index') }}" class="text-primary text-decoration-none small fw-medium d-inline-flex align-items-center gap-1">
                        Lihat semua <i class="bi bi-arrow-right" style="font-size: 0.75rem;"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-container">
                        <table class="table dashboard-table mb-0">
                            <thead>
                                <tr>
                                    <th>Petugas</th>
                                    <th>No Kendaraan</th>
                                    <th>Status</th>
                                    <th class="text-end">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransaksi as $t)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm"><i class="bi bi-person"></i></div>
                                            <span>
                                                @if($t->batch && $t->batch->team)
                                                    @foreach($t->batch->team->members as $m)
                                                        {{ $m->petugas->nama }}@if(!$loop->last), @endif
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($t->batch && $t->batch->truck)
                                            <code>{{ $t->batch->truck->plat_nomor }}</code>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $status = strtolower($t->status);
                                            $map = [
                                                'menunggu'    => ['class' => 'badge-menunggu', 'icon' => 'bi-hourglass-split'],
                                                'dalam_batch' => ['class' => 'badge-batch',    'icon' => 'bi-box-seam'],
                                                'dijemput'    => ['class' => 'badge-jemput',   'icon' => 'bi-truck'],
                                                'selesai'     => ['class' => 'badge-selesai',  'icon' => 'bi-check-circle'],
                                            ];
                                            $badge = $map[$status] ?? ['class' => 'badge-secondary', 'icon' => 'bi-circle'];
                                        @endphp
                                        <span class="status-badge {{ $badge['class'] }}">
                                            <i class="bi {{ $badge['icon'] }}"></i>
                                            {{ str_replace('_', ' ', ucfirst($t->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($t->tanggal_pickup)->format('d M Y') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox d-block mb-2" style="font-size: 2rem; opacity: 0.4;"></i>
                                        Tidak ada penjemputan yang sedang berlangsung.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT 1/3: Donut + truck status stacked --}}
        <div class="col-lg-4 d-flex flex-column gap-3">

            {{-- Donut chart card --}}
            <div class="card chart-card chart-clean">
                <div class="card-header">
                    <h5 class="card-title mb-0 fs-6 fw-semibold d-flex align-items-center gap-2">
                        <i class="bi bi-pie-chart text-muted"></i> Status Penjemputan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="orderStatusChart"
                            data-menunggu="{{ $transaksiMenunggu }}"
                            data-batch="{{ $transaksiBatch }}"
                            data-jemput="{{ $transaksiJemput }}"
                            data-selesai="{{ $transaksiSelesai }}">
                        </canvas>
                        <div class="chart-center-text">
                            <span class="center-label">Total</span>
                            <span class="center-value">{{ $totalTransaksi }}</span>
                        </div>
                    </div>
                    <div class="status-list mt-3">
                        <div class="status-row tile-menunggu">
                            <div class="status-row-left">
                                <span class="status-tile-dot"></span>
                                <span class="status-row-label">Menunggu</span>
                            </div>
                            <span class="status-row-value">{{ $transaksiMenunggu }}</span>
                        </div>
                        <div class="status-row tile-batch">
                            <div class="status-row-left">
                                <span class="status-tile-dot"></span>
                                <span class="status-row-label">Dalam Batch</span>
                            </div>
                            <span class="status-row-value">{{ $transaksiBatch }}</span>
                        </div>
                        <div class="status-row tile-jemput">
                            <div class="status-row-left">
                                <span class="status-tile-dot"></span>
                                <span class="status-row-label">Dijemput</span>
                            </div>
                            <span class="status-row-value">{{ $transaksiJemput }}</span>
                        </div>
                        <div class="status-row tile-selesai">
                            <div class="status-row-left">
                                <span class="status-tile-dot"></span>
                                <span class="status-row-label">Selesai</span>
                            </div>
                            <span class="status-row-value">{{ $transaksiSelesai }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Truck status card (compact list, monochrome with subtle dots) --}}
            <div class="card chart-clean">
                <div class="card-header">
                    <h5 class="card-title mb-0 fs-6 fw-semibold d-flex align-items-center gap-2">
                        <i class="bi bi-truck text-muted"></i> Status Trucks
                    </h5>
                </div>
                <div class="card-body p-2">
                    <div class="status-list">
                        <div class="status-row tile-idle">
                            <div class="status-row-left">
                                <span class="status-tile-dot"></span>
                                <span class="status-row-label">Tersedia</span>
                            </div>
                            <span class="status-row-value">{{ $truckIdle }}</span>
                        </div>
                        <div class="status-row tile-jemput">
                            <div class="status-row-left">
                                <span class="status-tile-dot"></span>
                                <span class="status-row-label">Penjemputan</span>
                            </div>
                            <span class="status-row-value">{{ $truckPenjemputan }}</span>
                        </div>
                        <div class="status-row tile-maintenance">
                            <div class="status-row-left">
                                <span class="status-tile-dot"></span>
                                <span class="status-row-label">Maintenance</span>
                            </div>
                            <span class="status-row-value">{{ $truckMaintenance }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
