@extends('layouts.admin')

@section('title', 'Data User')

@section('content')
<div class="d-flex flex-column gap-4">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h2 class="page-heading fs-4 fw-semibold mb-1">
                <i class="bi bi-people me-2"></i>Data User
            </h2>
            <p class="page-description text-secondary mb-0">Kelola data pengguna aplikasi Pungut-in</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah User</span>
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
                <i class="bi bi-table me-2"></i>Daftar User
            </h5>
            <span class="badge-count">{{ $users->count() }} Users</span>
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
                            <th>Saldo</th>
                            <th>Poin</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $u)
                            @continue($u->role === 'admin')
                            <tr>
                                <td><code>#{{ $u->id_user }}</code></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <span>{{ $u->nama }}</span>
                                    </div>
                                </td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->no_hp ?? '-' }}</td>
                                <td>
                                    @if(($u->role ?? 'user') === 'admin')
                                        -
                                    @else
                                        <span class="text-success">Rp {{ number_format($u->saldo_total) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if(($u->role ?? 'user') === 'admin')
                                        -
                                    @else
                                        <span class="badge-poin">{{ $u->poin_total }} pts</span>
                                    @endif
                                </td>
                                <td><span class="text-secondary small">{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('admin.users.edit', $u->id_user) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $u->id_user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                    <span>Belum ada user</span>
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
