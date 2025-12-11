@extends('layouts.admin')

@section('title', 'Daftar Team')

@section('content')
<div class="page-container">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-content">
            <h2 class="page-heading">
                <i class="bi bi-people-fill me-2"></i>Daftar Team
            </h2>
            <p class="page-description">Kelola team petugas pengambilan sampah</p>
        </div>
        <a href="{{ route('admin.teams.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i>
            <span>Buat Team</span>
        </a>
    </div>

    {{-- Data Table Card --}}
    <div class="card data-card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bi bi-table me-2"></i>Daftar Team
            </h5>
            <span class="badge-count">{{ $teams->count() }} Teams</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table data-table">
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
                                <td><span class="text-muted">{{ $team->tanggal }}</span></td>
                                <td>
                                    @if($team->truck)
                                        <div class="truck-cell">
                                            <i class="bi bi-truck text-primary"></i>
                                            <span>{{ $team->truck->nama }}</span>
                                            <code>{{ $team->truck->plat_nomor }}</code>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
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
                                        <span class="text-muted">-</span>
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="bi bi-inbox"></i>
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
