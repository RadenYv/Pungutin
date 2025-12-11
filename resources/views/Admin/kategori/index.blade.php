@extends('layouts.admin')

@section('title', 'Kategori Sampah')

@section('content')
<div class="page-container">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-content">
            <h2 class="page-heading">
                <i class="bi bi-tags me-2"></i>Kategori Sampah
            </h2>
            <p class="page-description">Kelola kategori dan harga sampah</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Kategori</span>
        </a>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Data Table Card --}}
    <div class="card data-card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bi bi-table me-2"></i>Daftar Kategori
            </h5>
            <span class="badge-count">{{ $kategori->count() }} Kategori</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table">
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
                                    <div class="kategori-cell">
                                        <i class="bi bi-recycle text-success"></i>
                                        <span>{{ $k->nama_kategori }}</span>
                                    </div>
                                </td>
                                <td><span class="text-success">Rp {{ number_format($k->harga_per_kg) }}</span></td>
                                <td><span class="badge-poin">{{ $k->poin_per_kg }} pts</span></td>
                                <td><span class="text-muted">{{ $k->created_at ? $k->created_at->format('d M Y') : '-' }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.kategori.edit', $k->id_kategori) }}" class="btn-action-sm btn-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.kategori.destroy', $k->id_kategori) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-sm btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="bi bi-inbox"></i>
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
