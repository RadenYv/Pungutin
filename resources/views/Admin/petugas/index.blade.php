@extends('layouts.admin')

@section('title', 'Data Petugas')

@section('content')
<div class="d-flex flex-column gap-4">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h2 class="page-heading fs-4 fw-semibold mb-1">
                <i class="bi bi-person-badge me-2"></i>Petugas
            </h2>
            <p class="page-description text-secondary mb-0">Kelola data petugas pengambilan sampah</p>
        </div>
        <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Petugas</span>
        </a>
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
            <span class="badge-count">{{ $petugas->count() }} Petugas</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($petugas as $p)
                            <tr>
                                <td><code>#{{ $p->id_petugas }}</code></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm">
                                            <i class="bi bi-person-badge"></i>
                                        </div>
                                        <span>{{ $p->nama }}</span>
                                    </div>
                                </td>
                                <td>{{ $p->email }}</td>
                                <td>{{ $p->no_hp ?? '-' }}</td>
                                <td>
                                    @if($p->status == 'aktif')
                                        <span class="status-badge status-success">
                                            <i class="bi bi-check-circle"></i> Aktif
                                        </span>
                                    @else
                                        <span class="status-badge status-secondary">
                                            <i class="bi bi-x-circle"></i> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td><span class="text-secondary small">{{ $p->created_at ? $p->created_at->format('d M Y') : '-' }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('admin.petugas.edit', $p->id_petugas) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.petugas.destroy', $p->id_petugas) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus petugas ini?')">
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
                                    <span>Belum ada petugas</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $petugas->links() }}
        </div>
    </div>
</div>
@endsection
