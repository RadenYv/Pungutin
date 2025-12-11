@extends('layouts.admin')

@section('title', 'Daftar Team')

@section('content')
<div class="d-flex flex-column gap-4">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h2 class="page-heading fs-4 fw-semibold mb-1">
                <i class="bi bi-people-fill me-2"></i>Daftar Team
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
            <h5 class="card-title mb-0 fs-6 fw-semibold d-flex align-items-center">
                <i class="bi bi-table me-2"></i>Daftar Team
            </h5>
            <span class="badge-count">{{ $teams->count() }} Teams</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table mb-0">
                    <thead>
                        <tr>
                            <th>ID Team</th>
                            <th>Tanggal</th>
                            <th>Truck</th>
                            <th>Anggota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teams as $team)
                            <tr>
                                <td><code>#{{ $team->id_team }}</code></td>
                                <td><span class="text-secondary">{{ $team->tanggal }}</span></td>
                                <td>
                                    @if($team->truck)
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-truck text-primary"></i>
                                            <span>{{ $team->truck->nama }}</span>
                                            <code>{{ $team->truck->plat_nomor }}</code>
                                        </div>
                                    @else
                                        <span class="text-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @forelse($team->members as $m)
                                        <div class="member-badge">
                                            <i class="bi bi-person"></i>
                                            {{ $m->petugas->nama }}
                                            <span class="role-tag">{{ $m->role }}</span>
                                        </div>
                                    @empty
                                        <span class="text-secondary">-</span>
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                    <span>Belum ada team</span>
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
