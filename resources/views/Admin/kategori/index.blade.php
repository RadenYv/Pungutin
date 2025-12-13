@extends('layouts.admin')

@section('title', 'Kategori Sampah')

@section('content')
<div class="d-flex flex-column gap-4">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h2 class="page-heading fs-4 fw-semibold mb-1">
                <i class="bi bi-tags me-2"></i>Kategori Sampah
            </h2>
            <p class="page-description text-secondary mb-0">Kelola kategori dan harga sampah</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Kategori</span>
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
            <h5 class="card-title mb-0 fs-6 fw-semibold d-flex align-items-center">
                <i class="bi bi-table me-2"></i>Daftar Kategori
            </h5>
            <span class="badge-count">{{ $kategori->count() }} Kategori</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Sampah</th>
                            <th>Harga per kg</th>
                            <th>Poin per kg</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategori as $k)
                            <tr>
                                <td><code>#{{ $k->id_kategori }}</code></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-recycle text-success"></i>
                                        <span>{{ $k->nama_kategori }}</span>
                                    </div>
                                </td>
                                <td><span class="text-success">Rp {{ number_format($k->harga_per_kg) }}</span></td>
                                <td><span class="badge-poin">{{ $k->poin_per_kg }} pts</span></td>
                                <td><span class="text-secondary small">{{ $k->created_at ? $k->created_at->format('d M Y') : '-' }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('admin.kategori.edit', $k->id_kategori) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.kategori.destroy', $k->id_kategori) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                    <span>Belum ada kategori</span>
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