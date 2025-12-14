@extends('layouts.admin')

@section('title', 'Data User')

@section('content')
<div class="d-flex flex-column gap-4">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h2 class="page-heading fs-4 fw-semibold mb-1">
                <i class="bi bi-people me-2"></i>Users
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
    <span class="badge-count">
        {{ $users->where('role', '!=', 'admin')->count() }} User
    </span>

    <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-2">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               class="form-control form-control-sm"
               placeholder="Cari user...">

        <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-search" style="font-size:16px;"></i>
                </button>
        </div>
    </form>
</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" width="80">ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $u)
                            @continue($u->role === 'admin')
                            <tr>
                                <td class="ps-4"><code>#{{ $u->id_user }}</code></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <span class="fw-medium">{{ $u->nama }}</span>
                                    </div>
                                </td>
                                <td class="text-secondary">{{ $u->email }}</td>
                                <td class="text-secondary">{{ $u->no_hp ?? '-' }}</td>
                                {{-- <td>
                                    @if(($u->role ?? 'user') === 'admin')
                                        -
                                     @else
                                       <span class="text-success">Rp {{ number_format($u->saldo_total) }}</span>
                                    @endif
                                </td> --}}
                                {{-- <td>
                                    @if(($u->role ?? 'user') === 'admin')
                                        -
                                    @else
                                        <span class="badge-poin">{{ $u->poin_total }} pts</span>
                                    @endif
                                </td> --}}
                                <td>
                                    <div class="d-flex align-items-center gap-2 text-secondary">
                                        <i class="bi bi-calendar4 opacity-50"></i>
                                        <span class="small">{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <a href="{{ route('admin.users.edit', $u->id_user) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $u->id_user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus user ini?')">
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
                                    <span>Belum ada user</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
