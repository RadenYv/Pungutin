@extends('layouts.admin')

@section('title', 'Tambah Truck')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Tambah Truck</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.trucks.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>

                <div class="mb-3">
                    <label for="plat_nomor" class="form-label">Plat Nomor</label>
                    <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" required>
                </div>

                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas (kg)</label>
                    <input type="number" class="form-control" id="kapasitas" name="kapasitas" required>
                </div>

                <div class="mb-3">
                    <label for="warehouse" class="form-label">Warehouse</label>
                    <input type="text" class="form-control" id="warehouse" name="warehouse" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="idle">Idle</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="penjemputan">Penjemputan</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.trucks.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
