@extends('layouts.admin')

@section('title', 'Daftar Team')

@section('content')
<div class="d-flex flex-column gap-4">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h2 class="page-heading fs-4 fw-semibold mb-1">
                <i class="bi bi-people-fill me-2"></i>Teams
            </h2>
            <p class="page-description text-secondary mb-0">Kelola team petugas pengambilan sampah</p>
        </div>
        <a href="{{ route('admin.teams.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i>
            <span>Buat Team</span>
        </a>
    </div>

    {{-- Data Table Card --}}
    <div class="card data-card rounded-3">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <span class="badge-count">{{ $teams->total() }} Team</span>
            <form method="GET"
                action="{{ route('admin.teams.index') }}"
                class="d-flex gap-2">
            <input type="text"
               name="search"
               value="{{ request('search') }}"
               class="form-control form-control-sm"
               placeholder="Cari id / truck / petugas">
            <button class="btn btn-sm btn-primary">
                <i class="bi bi-search"></i>
            </button>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" width="100">ID Team</th>
                            <th>Tanggal</th>
                            <th>Truck</th>
                            <th>Anggota</th>
                            <th class="ps-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teams as $team)
                            <tr>
                                <td class="ps-4"><code>#{{ $team->id_team }}</code></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2 text-secondary">
                                        <i class="bi bi-calendar4 opacity-50"></i>
                                        <span>{{ $team->tanggal }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($team->truck)
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-truck text-primary"></i>
                                            <span class="fw-medium">{{ $team->truck->nama }}</span>
                                            <code>{{ $team->truck->plat_nomor }}</code>
                                        </div>
                                    @else
                                        <span class="text-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        @forelse($team->members as $m)
                                            <div class="member-badge">
                                                <i class="bi bi-person"></i>
                                                {{ $m->petugas->nama }}
                                                <span class="role-tag">{{ $m->role }}</span>
                                            </div>
                                        @empty
                                            <span class="text-secondary">-</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="ps-4">
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <a href="{{ route('admin.teams.edit', $team->id_team) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.teams.destroy', $team->id_team) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus team ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                    <span>Belum ada team</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $teams->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection