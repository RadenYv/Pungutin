@extends('layouts.admin')

@section('title', 'Tambah Truck')

@section('content')
<h2>Tambah Truck</h2>

<form action="{{ route('admin.trucks.store') }}" method="POST">
    @csrf

    <label>Nama:</label>
    <input type="text" name="nama" required><br><br>

    <label>Plat Nomor:</label>
    <input type="text" name="plat_nomor" required><br><br>

    <label>Kapasitas (kg):</label>
    <input type="number" name="kapasitas" required><br><br>

    <label>Warehouse:</label>
    <input type="text" name="warehouse" required><br><br>

    <label>Status:</label>
    <select name="status" required>
        <option value="idle">Idle</option>
        <option value="maintenance">Maintenance</option>
        <option value="penjemputan">Penjemputan</option>
    </select><br><br>

    <button type="submit">Simpan</button>
</form>
@endsection
