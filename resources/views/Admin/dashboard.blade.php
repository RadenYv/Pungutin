@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="d-flex flex-column gap-4">

    {{-- Welcome Card --}}
    <div class="row g-4">
        <div class="col-12">
            <div class="card welcome-card rounded-3">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h2 class="fs-4 fw-semibold mb-2">Hello, {{ auth('admin')->user()->nama }}! 👋</h2>
                            <p class="mb-1">Hari ini kamu memiliki <strong class="text-primary fs-5">{{ $transaksiMenunggu }}</strong> pesanan baru!</p>
                            <p class="text-secondary mb-0 small">Pesan menunggu untuk ditindak lanjuti.</p>
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
    <div class="row g-4">
        {{-- Donut Chart Card --}}
        <div class="col-lg-4">
            <div class="card chart-card rounded-3 h-100">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="card-title mb-0 fs-6 fw-semibold d-flex align-items-center">
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
            
            {{-- Section: Transaksi --}}
            <h6 class="text-muted text-uppercase small fw-bold mb-3">Penjemputan</h6>
            <div class="row g-4 mb-4">
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

            {{-- Section: Truck Status --}}
            <h6 class="text-muted text-uppercase small fw-bold mb-3">Truck Status</h6>
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-md-4">
                    <div class="card stat-card stat-success">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ $truckIdle }}</span>
                                <span class="stat-label">Available/Idle</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card stat-card stat-primary">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="bi bi-truck"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ $truckPenjemputan }}</span>
                                <span class="stat-label">Penjemputan</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card stat-card stat-warning">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="bi bi-tools"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ $truckMaintenance }}</span>
                                <span class="stat-label">Maintenance</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section: Accounts --}}
            <h6 class="text-muted text-uppercase small fw-bold mb-3">Accounts</h6>
            <div class="row g-4">
                <div class="col-sm-6 col-md-6">
                    <div class="card stat-card stat-info">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ $totalUsers }}</span>
                                <span class="stat-label">Total Users</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="card stat-card stat-purple">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-value">{{ $totalPetugas }}</span>
                                <span class="stat-label">Total Petugas</span>
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

            {{-- Batch Status Chart --}}
            <div class="card rounded-3 mb-4">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="card-title mb-0 fs-6 fw-semibold d-flex align-items-center">
                        <i class="bi bi-bar-chart me-2"></i>Batch Status Overview
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="batchStatusChart" 
                        data-pending="{{ $batchPending }}"
                        data-tugas="{{ $batchTugas }}"
                        data-berjalan="{{ $batchBerjalan }}"
                        data-selesai="{{ $batchSelesai }}"
                        style="max-height: 300px;">
                    </canvas>
                </div>
            </div>

            {{-- History Transaksi Table --}}
            <div class="card rounded-3">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="card-title mb-0 fs-6 fw-semibold d-flex align-items-center">
                        <i class="bi bi-clock-history me-2"></i>Penjemputan selesai
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
                                        Belum ada transaksi yang selesai.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.transaksi.index') }}" class="text-primary text-decoration-none d-inline-flex align-items-center gap-2 small fw-medium">
                        View All Penjemputan
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-4">

            {{-- Profile Card --}}
            <div class="card profile-card rounded-3 mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="profile-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-6 fw-semibold mb-1">{{ auth('admin')->user()->nama }}</h5>
                            <span class="role-badge">Administrator</span>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots"></i></button>
                    </div>

                    <div class="d-flex gap-2 mb-4">
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

                    <div class="border-top pt-3">
                        <div class="detail-row">
                            <span class="detail-label">Company</span>
                            <span class="detail-value">Pungut-in</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Joining Date</span>
                            <span class="detail-value">{{ auth('admin')->user()->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Penjemputan aktif    </span>
                            <span class="detail-value highlight">{{ $transaksiBatch }} Active</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Calendar Widget --}}
            <div class="card rounded-3">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="card-title mb-0 fs-6 fw-semibold d-flex align-items-center">
            <i class="bi bi-calendar3 me-2"></i>Personal Calendar
        </h5>
        <div class="d-flex gap-1">
            <button id="prevMonth" class="btn btn-sm btn-outline-secondary" type="button">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button id="nextMonth" class="btn btn-sm btn-outline-secondary" type="button">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div id="calendarMonth" class="text-center fw-semibold mb-2"></div>

        <div id="calendarGrid" class="calendar-grid"></div>

        <div class="calendar-legend mt-3">
            <span><i class="bi bi-circle-fill text-danger"></i> Holiday</span>
            <span class="ms-3"><i class="bi bi-circle-fill text-primary"></i> Leave</span>
        </div>
    </div>
</div>

<style>
.calendar-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:6px}
.cal-header{font-size:.75rem;text-align:center;font-weight:600;color:#6c757d}
.cal-cell{height:38px;display:flex;align-items:center;justify-content:center;border-radius:8px;cursor:pointer;transition:.2s}
.cal-cell:hover{background:#f1f3f5}
.cal-cell.empty{cursor:default}
.cal-cell.is-today{background:#0d6efd;color:#fff;font-weight:600}
</style>

<script>
(() => {
    const grid = document.getElementById('calendarGrid'),
          title = document.getElementById('calendarMonth'),
          prev = document.getElementById('prevMonth'),
          next = document.getElementById('nextMonth');
    let date = new Date();

    function render(d){
        grid.innerHTML='';
        const y=d.getFullYear(),m=d.getMonth(),
              first=new Date(y,m,1).getDay(),
              total=new Date(y,m+1,0).getDate(),
              today=new Date();
        title.innerText=d.toLocaleDateString('en-US',{month:'long',year:'numeric'});
        ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].forEach(h=>{
            const e=document.createElement('div');e.className='cal-header';e.innerText=h;grid.appendChild(e);
        });
        for(let i=0;i<first;i++)grid.appendChild(Object.assign(document.createElement('div'),{className:'cal-cell empty'}));
        for(let i=1;i<=total;i++){
            const c=document.createElement('div');
            c.className='cal-cell';
            c.innerText=i;
            if(i===today.getDate()&&m===today.getMonth()&&y===today.getFullYear())c.classList.add('is-today');
            grid.appendChild(c);
        }
    }

    prev.onclick=()=>{date.setMonth(date.getMonth()-1);render(date)};
    next.onclick=()=>{date.setMonth(date.getMonth()+1);render(date)};
    render(date);
})();
</script>


        </div>

    </div>

</div>

@endsection
