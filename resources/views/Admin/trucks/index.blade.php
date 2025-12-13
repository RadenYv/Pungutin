@extends('layouts.admin')

@section('title', 'Daftar Truck')

@section('content')
<div class="d-flex flex-column gap-4">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h2 class="page-heading fs-4 fw-semibold mb-1">
                <i class="bi bi-truck me-2"></i>Trucks
            </h2>
            <p class="page-description text-secondary mb-0">Kelola armada truck pengambilan sampah</p>
        </div>
        <a href="{{ route('admin.trucks.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Truck</span>
        </a>
    </div>

    {{-- Data Table Card --}}
    <div class="card data-card rounded-3">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <span class="badge-count">{{ $trucks->count() }} Truck</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Plat Nomor</th>
                            <th>Kapasitas</th>
                            <th>Warehouse</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trucks as $t)
                            <tr>
                                <td><code>#{{ $t->id_truck }}</code></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-truck text-primary"></i>
                                        <span>{{ $t->nama }}</span>
                                    </div>
                                </td>
                                <td><code>{{ $t->plat_nomor }}</code></td>
                                <td>{{ $t->kapasitas }} kg</td>
                                <td>{{ $t->warehouse }}</td>
                                <td>
                                    @if($t->status == 'tersedia')
                                        <span class="status-badge status-success">
                                            <i class="bi bi-check-circle"></i> Tersedia
                                        </span>
                                    @elseif($t->status == 'digunakan')
                                        <span class="status-badge status-warning">
                                            <i class="bi bi-exclamation-circle"></i> Digunakan
                                        </span>
                                    @else
                                        <span class="status-badge status-secondary">
                                            <i class="bi bi-x-circle"></i> {{ ucfirst($t->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('admin.trucks.edit', $t->id_truck) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.trucks.destroy', $t->id_truck) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus truck ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                    <span>Belum ada truck</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $trucks->links() }}
        </div>
    </div>
</div>
@endsection
