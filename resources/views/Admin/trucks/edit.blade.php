@extends('layouts.admin')

@section('title', 'Edit Truck')

@section('content')

<h2>Edit Truck</h2>

<form action="{{ route('admin.trucks.update', $truck->id_truck) }}" method="POST">
    @csrf
    @method('PUT')
    
    <label>Nama:</label>
    <input type="text" name="nama" value="{{ old('nama', $truck->nama) }}" class="input" required>
    <br><br>
    <label>Plat Nomor:</label>
    <input type="text" name="plat_nomor" value="{{ old('plat_nomor', $truck->plat_nomor) }}" class="input" required>
    <br><br>
    <label>Kapasitas (kg):</label>
    <input type="number" name="kapasitas" value="{{ old('kapasitas', $truck->kapasitas) }}" class="input" required>
    <br><br>
    <label>Warehouse:</label>
    <input type="text" name="warehouse" value="{{ old('warehouse', $truck->warehouse) }}" class="input" required>
    <br><br>
    <label>Status:</label>
    <select name="status" class="input">
        <option value="idle"        {{ $truck->status === 'idle' ? 'selected' : '' }}>Idle</option>
        <option value="maintenance" {{ $truck->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        <option value="penjemputan" {{ $truck->status === 'penjemputan' ? 'selected' : '' }}>Penjemputan</option>
    </select>
    <br><br>

    <button type="submit">Update</button>

</form>

@endsection
