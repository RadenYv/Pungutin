@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard-container">

    {{-- Welcome Card --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card welcome-card">
                <div class="card-body">
                    <div class="welcome-content">
                        <div class="welcome-text">
                            <h2>Hello, {{ auth('admin')->user()->nama }}! 👋</h2>
                            <p>Hari ini kamu memiliki <strong>{{ $transaksiMenunggu }}</strong> pesanan baru!</p>
                            <p class="text-muted">Pesan menunggu untuk ditindak lanjuti.</p>
                        </div>
                        <div class="welcome-illustration">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Row with Donut Chart --}}
    <div class="row g-4 mb-4">
        {{-- Donut Chart Card --}}
        <div class="col-lg-4">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="bi bi-pie-chart me-2"></i>Order Status
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Chart Canvas Container --}}
                    <div class="chart-container">
                        <canvas id="orderStatusChart"
                            data-menunggu="{{ $transaksiMenunggu }}"
                            data-batch="{{ $transaksiBatch }}"
                            data-jemput="{{ $transaksiJemput }}"
                            data-selesai="{{ $transaksiSelesai }}">
                        </canvas>
                        {{-- Center Text Overlay --}}
                        <div class="chart-center-text">
                            <span class="center-label">Total</span>
                            <span class="center-value">{{ $transaksiMenunggu + $transaksiBatch + $transaksiJemput + $transaksiSelesai }}</span>
                        </div>
                    </div>
                    {{-- Legend --}}
                    <div class="chart-legend">
                        <div class="legend-item">
                            <span class="legend-color" style="background: #ffc107;"></span>
                            <span class="legend-label">Menunggu</span>
                            <span class="legend-value">{{ $transaksiMenunggu }}</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background: #6c757d;"></span>
                            <span class="legend-label">Dalam Batch</span>
                            <span class="legend-value">{{ $transaksiBatch }}</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background: #0d6efd;"></span>
                            <span class="legend-label">Dijemput</span>
                            <span class="legend-value">{{ $transaksiJemput }}</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background: #198754;"></span>
                            <span class="legend-label">Selesai</span>
                            <span class="legend-value">{{ $transaksiSelesai }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Stats Cards --}}
        <div class="col-lg-8">
            <div class="row g-4 h-100">
                <div class="col-sm-6 col-md-3">
                    <div class="card stat-card stat-warning">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ $transaksiMenunggu }}</span>
                                <span class="stat-label">Menunggu</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card stat-card stat-secondary">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ $transaksiBatch }}</span>
                                <span class="stat-label">Dalam Batch</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card stat-card stat-primary">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="bi bi-truck"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ $transaksiJemput }}</span>
                                <span class="stat-label">Dijemput</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card stat-card stat-success">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ $transaksiSelesai }}</span>
                                <span class="stat-label">Selesai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT COLUMN --}}
        <div class="col-lg-8">

            {{-- History Transaksi Table --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="bi bi-clock-history me-2"></i>History Transaksi
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-container">
                        <table class="table dashboard-table">
                            <thead>
                                <tr>
                                    <th>Petugas</th>
                                    <th>No Kendaraan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransaksi as $t)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <span>
                                                @if($t->batch && $t->batch->team)
                                                    @foreach($t->batch->team->members as $m)
                                                        {{ $m->petugas->nama }}@if(!$loop->last), @endif
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <code>{{ $t->batch->truck->plat_nomor ?? '-' }}</code>
                                    </td>
                                    <td>
                                        @php
                                            $status = strtolower($t->status);
                                            $map = [
                                                'menjemput' => ['class' => 'badge-primary', 'icon' => 'bi-truck'],
                                                'dijemput' => ['class' => 'badge-primary', 'icon' => 'bi-truck'],
                                                'menunggu' => ['class' => 'badge-warning', 'icon' => 'bi-hourglass-split'],
                                                'selesai' => ['class' => 'badge-success', 'icon' => 'bi-check-circle'],
                                                'dalam_batch' => ['class' => 'badge-secondary', 'icon' => 'bi-box']
                                            ];
                                            $badge = $map[$status] ?? ['class' => 'badge-secondary', 'icon' => 'bi-question'];
                                        @endphp
                                        <span class="status-badge {{ $badge['class'] }}">
                                            <i class="bi {{ $badge['icon'] }}"></i>
                                            {{ str_replace('_', ' ', ucfirst($t->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $t->tanggal_pickup }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Belum ada transaksi
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.transaksi.index') }}" class="view-more-link">
                        View All Transactions
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-4">

            {{-- Calendar Widget --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="bi bi-calendar3 me-2"></i>Personal Calendar
                    </h5>
                    <div class="calendar-nav">
                        <button class="btn-icon" type="button"><i class="bi bi-chevron-left"></i></button>
                        <button class="btn-icon" type="button"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="calendar-month">{{ now()->format('F Y') }}</div>
                    <div class="calendar-grid">
                        <div class="cal-header">Sun</div>
                        <div class="cal-header">Mon</div>
                        <div class="cal-header">Tue</div>
                        <div class="cal-header">Wed</div>
                        <div class="cal-header">Thu</div>
                        <div class="cal-header">Fri</div>
                        <div class="cal-header">Sat</div>
                        @php
                            $firstDay = now()->startOfMonth()->dayOfWeek;
                            $daysInMonth = now()->daysInMonth;
                        @endphp
                        @for($i = 0; $i < $firstDay; $i++)
                            <div class="cal-cell empty"></div>
                        @endfor
                        @for($i = 1; $i <= $daysInMonth; $i++)
                            <div class="cal-cell {{ $i == now()->day ? 'is-today' : '' }}">{{ $i }}</div>
                        @endfor
                    </div>
                    <div class="calendar-legend">
                        <span><i class="bi bi-circle-fill text-danger"></i> Holiday</span>
                        <span><i class="bi bi-circle-fill text-primary"></i> Leave</span>
                    </div>
                </div>
            </div>

            {{-- Profile Card --}}
            <div class="card profile-card">
                <div class="card-body">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="profile-info">
                            <h5>{{ auth('admin')->user()->nama }}</h5>
                            <span class="role-badge">Administrator</span>
                        </div>
                        <button class="btn-icon"><i class="bi bi-three-dots"></i></button>
                    </div>

                    <div class="profile-actions">
                        <button class="btn-action" title="Call">
                            <i class="bi bi-telephone"></i>
                        </button>
                        <button class="btn-action" title="Email">
                            <i class="bi bi-envelope"></i>
                        </button>
                        <button class="btn-action" title="Message">
                            <i class="bi bi-chat-dots"></i>
                        </button>
                    </div>

                    <div class="profile-details">
                        <div class="detail-row">
                            <span class="detail-label">Company</span>
                            <span class="detail-value">Pungut-in</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Joining Date</span>
                            <span class="detail-value">{{ auth('admin')->user()->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Active Projects</span>
                            <span class="detail-value highlight">{{ $transaksiBatch }} Active</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
