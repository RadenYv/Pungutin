@extends('layouts.admin')

@section('title', 'Edit Truck')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Edit Truck</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.trucks.update', $truck->id_truck) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $truck->nama) }}" required>
                </div>

                <div class="mb-3">
                    <label for="plat_nomor" class="form-label">Plat Nomor</label>
                    <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" value="{{ old('plat_nomor', $truck->plat_nomor) }}" required>
                </div>

                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas (kg)</label>
                    <input type="number" class="form-control" id="kapasitas" name="kapasitas" value="{{ old('kapasitas', $truck->kapasitas) }}" required>
                </div>

                <div class="mb-3">
                    <label for="warehouse" class="form-label">Warehouse</label>
                    <input type="text" class="form-control" id="warehouse" name="warehouse" value="{{ old('warehouse', $truck->warehouse) }}" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="idle"        {{ $truck->status === 'idle' ? 'selected' : '' }}>Idle</option>
                        <option value="maintenance" {{ $truck->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="penjemputan" {{ $truck->status === 'penjemputan' ? 'selected' : '' }}>Penjemputan</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.trucks.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
