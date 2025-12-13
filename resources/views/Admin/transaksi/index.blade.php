@extends('layouts.admin')

@section('title', 'Data Penjemputan')

@section('content')
<div class="d-flex flex-column gap-4">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h2 class="page-heading fs-4 fw-semibold mb-1">
                <i class="bi bi-box-seam me-2"></i>Penjemputan
            </h2>
            <p class="page-description text-secondary mb-0">Kelola penjemputan pengambilan sampah</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Data Table Card --}}
    <div class="card data-card rounded-3">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <span class="badge-count">{{ $transaksi->count() }} Penjemputan</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Kategori</th>
                            <th>Berat</th>
                            <th>Total</th>
                            <th>Poin</th>
                            <th>Status</th>
                            <th>Batch</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi as $item)
                            <tr>
                                <td><code>#{{ $item->id_transaksi }}</code></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <span>{{ $item->user->nama ?? '-' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="kategori-tag">
                                        <i class="bi bi-recycle"></i>
                                        {{ $item->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>
                                <td>{{ number_format($item->berat_kg, 2) }} kg</td>
                                <td><span class="text-success">Rp {{ number_format($item->total_uang, 0, ',', '.') }}</span></td>
                                <td><span class="badge-poin">{{ $item->poin_didapat }} pts</span></td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'menunggu' => ['class' => 'status-warning', 'icon' => 'bi-hourglass-split'],
                                            'dalam_batch' => ['class' => 'status-secondary', 'icon' => 'bi-box'],
                                            'dijemput' => ['class' => 'status-primary', 'icon' => 'bi-truck'],
                                            'selesai' => ['class' => 'status-success', 'icon' => 'bi-check-circle'],
                                        ];
                                        $badge = $statusMap[$item->status] ?? ['class' => 'status-secondary', 'icon' => 'bi-question'];
                                    @endphp
                                    <span class="status-badge {{ $badge['class'] }}">
                                        <i class="bi {{ $badge['icon'] }}"></i>
                                        {{ str_replace('_', ' ', ucfirst($item->status)) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($item->batch)
                                        <code>Batch #{{ $item->batch->id_batch }}</code>
                                        <small class="text-secondary d-block">{{ $item->batch->start_time }} - {{ $item->batch->end_time }}</small>
                                    @else
                                        <span class="text-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status == 'menunggu')
                                        <form action="{{ route('admin.transaksi.assignBatch', $item->id_transaksi) }}" method="POST" class="d-flex align-items-center gap-2">
                                            @csrf
                                            <select name="id_batch" class="form-select form-select-sm" required>
                                                <option value="">Pilih Batch</option>
                                                @foreach($batches as $b)
                                                    <option value="{{ $b->id_batch }}">
                                                        Batch #{{ $b->id_batch }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </form>
                                    @elseif ($item->status == 'dalam_batch')
                                        <form action="{{ route('admin.transaksi.assignBatch', $item->id_transaksi) }}" method="POST" class="d-flex align-items-center gap-2">
                                            @csrf
                                            <select name="id_batch" class="form-select form-select-sm" required>
                                                <option value="">Pindah ke</option>
                                                @foreach($batches as $b)
                                                    <option value="{{ $b->id_batch }}">
                                                        Batch #{{ $b->id_batch }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="bi bi-arrow-right"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-secondary">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                    <span>Belum ada penjemputan</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $transaksi->links() }}
        </div>
    </div>
</div>
@endsection
