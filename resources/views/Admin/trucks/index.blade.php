@extends('layouts.admin')

@section('title', 'Daftar Truck')

@section('content')
<div class="page-container">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-content">
            <h2 class="page-heading">
                <i class="bi bi-truck me-2"></i>Daftar Truck
            </h2>
            <p class="page-description">Kelola armada truck pengambilan sampah</p>
        </div>
        <a href="{{ route('admin.trucks.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Truck</span>
        </a>
    </div>

    {{-- Data Table Card --}}
    <div class="card data-card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bi bi-table me-2"></i>Daftar Truck
            </h5>
            <span class="badge-count">{{ $trucks->count() }} Trucks</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table">
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
                                    <div class="truck-cell">
                                        <i class="bi bi-truck text-primary"></i>
                                        <span>{{ $t->nama }}</span>
                                    </div>
                                </td>
                                <td><code>{{ $t->plat_nomor }}</code></td>
                                <td>{{ $t->kapasitas }} kg</td>
                                <td>{{ $t->warehouse }}</td>
                                <td>
                                    @if($t->status == 'tersedia')
                                        <span class="status-badge badge-success">
                                            <i class="bi bi-check-circle"></i> Tersedia
                                        </span>
                                    @elseif($t->status == 'digunakan')
                                        <span class="status-badge badge-warning">
                                            <i class="bi bi-exclamation-circle"></i> Digunakan
                                        </span>
                                    @else
                                        <span class="status-badge badge-secondary">
                                            <i class="bi bi-x-circle"></i> {{ ucfirst($t->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.trucks.edit', $t->id_truck) }}" class="btn-action-sm btn-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.trucks.destroy', $t->id_truck) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-sm btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus truck ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <span>Belum ada truck</span>
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
