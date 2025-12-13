@extends('layouts.admin')

@section('title', 'Edit Team')

@section('content')
<div class="d-flex flex-column gap-4">
    {{-- Page Header --}}
    <div class="page-header">
        <h2 class="page-heading fs-4 fw-semibold mb-1">
            <i class="bi bi-pencil me-2"></i>Edit Team
        </h2>
        <p class="page-description text-secondary mb-0">Edit informasi team petugas pengambilan sampah</p>
    </div>

    {{-- Form Card --}}
    <div class="card rounded-3">
        <div class="card-header">
            <h5 class="card-title mb-0 fs-6 fw-semibold">
                <i class="bi bi-people-fill me-2"></i>Form Edit Team
            </h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-start gap-2">
                    <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.teams.update', $team->id_team) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- Truck Selection --}}
                    <div class="col-md-6">
                        <label for="id_truck" class="form-label fw-medium">
                            <i class="bi bi-truck me-1"></i>Truck
                        </label>
                        <select name="id_truck" id="id_truck" class="form-select" required>
                            <option value="">Pilih Truck</option>
                            @foreach($trucks as $t)
                                <option value="{{ $t->id_truck }}" 
                                    {{ old('id_truck', $team->id_truck) == $t->id_truck ? 'selected' : '' }}>
                                    {{ $t->nama }} ({{ $t->plat_nomor }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date --}}
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label fw-medium">
                            <i class="bi bi-calendar-event me-1"></i>Tanggal
                        </label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" 
                            value="{{ old('tanggal', $team->tanggal) }}" required>
                    </div>

                    {{-- Driver Selection --}}
                    <div class="col-md-6">
                        <label for="driver" class="form-label fw-medium">
                            <i class="bi bi-person-fill me-1"></i>Driver
                        </label>
                        <select name="driver" id="driver" class="form-select" required>
                            <option value="">Pilih Driver</option>
                            @foreach($petugas as $p)
                                <option value="{{ $p->id_petugas }}" 
                                    {{ old('driver', $currentDriver?->id_petugas) == $p->id_petugas ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Co-Driver Selection --}}
                    <div class="col-md-6">
                        <label for="co_driver" class="form-label fw-medium">
                            <i class="bi bi-person me-1"></i>Co-Driver 
                            <span class="text-muted small">(Opsional)</span>
                        </label>
                        <select name="co_driver" id="co_driver" class="form-select">
                            <option value="">Pilih Co-Driver</option>
                            @foreach($petugas as $p)
                                <option value="{{ $p->id_petugas }}" 
                                    {{ old('co_driver', $currentCoDriver?->id_petugas) == $p->id_petugas ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-check-lg"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                    <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-x-lg"></i>
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
