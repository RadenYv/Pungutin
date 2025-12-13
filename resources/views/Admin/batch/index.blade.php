@extends('layouts.admin')

@section('title', 'Daftar Batch')

@section('content')
<div class="d-flex flex-column gap-4">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h2 class="page-heading fs-4 fw-semibold mb-1">
                <i class="bi bi-collection me-2"></i>Daftar Batch
            </h2>
            <p class="page-description text-secondary mb-0">Kelola batch pengambilan sampah</p>
        </div>
        <a href="{{ route('admin.batches.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i>
            <span>Buat Batch</span>
        </a>
    </div>

    {{-- Data Table Card --}}
    <div class="card data-card rounded-3">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <h5 class="card-title mb-0 fs-6 fw-semibold d-flex align-items-center">
                <i class="bi bi-table me-2"></i>Daftar Batch
            </h5>
            <span class="badge-count">{{ $batches->count() }} Batches</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table mb-0">
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
                                <td><span class="text-secondary">{{ $b->tanggal }}</span></td>
                                <td>
                                    <span class="time-badge">
                                        <i class="bi bi-clock"></i>
                                        {{ $b->pickup_window }}
                                    </span>
                                </td>
                                <td>
                                    @if($b->truck)
                                        <div class="d-flex align-items-center gap-2">
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
                                        <span class="text-secondary">-</span>
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
                                    <div class="d-flex flex-column gap-2">
                                        {{-- Assign Team (only if pending) --}}
                                        @if($b->status === 'pending')
                                            <form action="{{ route('admin.batches.assignTeam', $b->id_batch) }}" method="POST" class="d-flex align-items-center gap-2">
                                                @csrf
                                                <select name="id_team" class="form-select form-select-sm">
                                                    <option value="">Pilih Team</option>
                                                    @foreach($teams as $t)
                                                        <option value="{{ $t->id_team }}">
                                                            Team #{{ $t->id_team }} - {{ $t->truck->nama ?? 'Tanpa Truck' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm" title="Assign Team">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                                <a href="{{ route('admin.batches.transaksi', $b->id_batch) }}" class="btn btn-outline-info btn-sm" title="Lihat Transaksi">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </form>
                                        @endif
                                        {{-- Start Batch (only if ditugaskan) --}}
                                        @if($b->status === 'ditugaskan')
                                            <form action="{{ route('admin.batches.start', $b->id_batch) }}" method="POST" class="d-flex align-items-center gap-2">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" title="Mulai Batch">
                                                    <i class="bi bi-play-fill"></i> Mulai
                                                </button>
                                                <a href="{{ route('admin.batches.transaksi', $b->id_batch) }}" class="btn btn-outline-info btn-sm" title="Lihat Transaksi">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </form>
                                        @endif

                                        {{-- Finish Batch (only if berjalan) --}}
                                        @if($b->status === 'berjalan')
                                            <form action="{{ route('admin.batches.selesai', $b->id_batch) }}" method="POST" class="d-flex align-items-center gap-2">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm" title="Selesaikan Batch">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                                <a href="{{ route('admin.batches.transaksi', $b->id_batch) }}" class="btn btn-outline-info btn-sm" title="Lihat Transaksi">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
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