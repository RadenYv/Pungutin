@extends('layouts.admin')

@section('title', 'Daftar Batch')

@section('content')
<div class="page-container">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-content">
            <h2 class="page-heading">
                <i class="bi bi-collection me-2"></i>Daftar Batch
            </h2>
            <p class="page-description">Kelola batch pengambilan sampah</p>
        </div>
        <a href="{{ route('admin.batches.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i>
            <span>Buat Batch</span>
        </a>
    </div>

    {{-- Data Table Card --}}
    <div class="card data-card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bi bi-table me-2"></i>Daftar Batch
            </h5>
            <span class="badge-count">{{ $batches->count() }} Batches</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>ID Batch</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Truck</th>
                            <th>Petugas</th>
                            <th>Status</th>
                            <th>Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($batches as $b)
                            <tr>
                                <td><code>#{{ $b->id_batch }}</code></td>
                                <td><span class="text-muted">{{ $b->tanggal }}</span></td>
                                <td>
                                    <span class="time-badge">
                                        <i class="bi bi-clock"></i>
                                        {{ $b->start_time }} - {{ $b->end_time }}
                                    </span>
                                </td>
                                <td>
                                    @if($b->truck)
                                        <div class="truck-cell">
                                            <i class="bi bi-truck text-primary"></i>
                                            <span>{{ $b->truck->nama }}</span>
                                            <code>{{ $b->truck->plat_nomor }}</code>
                                        </div>
                                    @else
                                        <span class="text-danger">
                                            <i class="bi bi-exclamation-triangle"></i> Belum ada truck
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($b->team)
                                        @foreach($b->team->members as $m)
                                            <div class="member-badge">
                                                <i class="bi bi-person"></i>
                                                {{ $m->petugas->nama }}
                                                <span class="role-tag">{{ $m->role }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($b->status) {
                                            'pending' => 'status-warning',
                                            'ditugaskan' => 'status-info',
                                            'berjalan' => 'status-primary',
                                            'selesai' => 'status-success',
                                            default => 'status-secondary'
                                        };
                                        $statusLabel = match($b->status) {
                                            'pending' => 'Pending',
                                            'ditugaskan' => 'Ditugaskan',
                                            'berjalan' => 'Berjalan',
                                            'selesai' => 'Selesai',
                                            default => $b->status
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $b->transaksi->count() }} transaksi</span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        {{-- Assign Team (only if pending) --}}
                                        @if($b->status === 'pending')
                                            <form action="{{ route('admin.batches.assignTeam', $b->id_batch) }}" method="POST" class="batch-form">
                                                @csrf
                                                <select name="id_team" class="form-select-sm">
                                                    <option value="">Pilih Team</option>
                                                    @foreach($teams as $t)
                                                        <option value="{{ $t->id_team }}">
                                                            Team #{{ $t->id_team }} - {{ $t->truck->nama ?? 'Tanpa Truck' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn-action-sm btn-primary-sm" title="Assign Team">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                                </button>
                                                <a href="{{ route('admin.batches.transaksi', $b->id_batch) }}" class="btn-action-sm btn-info-sm ms-1" title="Lihat Transaksi">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </form>
                                        @endif
                                        {{-- Start Batch (only if ditugaskan) --}}
                                        @if($b->status === 'ditugaskan')
                                            <form action="{{ route('admin.batches.start', $b->id_batch) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-action-sm btn-success-sm" title="Mulai Batch">
                                                    <i class="bi bi-play-fill"></i> Mulai
                                                </button>
                                                </button>
                                                <a href="{{ route('admin.batches.transaksi', $b->id_batch) }}" class="btn-action-sm btn-info-sm ms-1" title="Lihat Transaksi">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </form>
                                        @endif

                                        {{-- Finish Batch (only if berjalan) --}}
                                        @if($b->status === 'berjalan')
                                            <form action="{{ route('admin.batches.selesai', $b->id_batch) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-action-sm btn-warning-sm" title="Selesaikan Batch">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                                <a href="{{ route('admin.batches.transaksi', $b->id_batch) }}" class="btn-action-sm btn-info-sm ms-1" title="Lihat Transaksi">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <span>Belum ada batch</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
