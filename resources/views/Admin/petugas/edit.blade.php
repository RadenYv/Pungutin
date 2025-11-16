@extends('layouts.admin')

@section('title', 'Edit Petugas')

@section('content')
<h2>Edit Petugas</h2>

<form action="{{ route('admin.petugas.update', $petugas->id_petugas) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama:</label><br>
    <input type="text" name="nama" value="{{ $petugas->nama }}" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="{{ $petugas->email }}" required><br><br>

    <label>No HP:</label><br>
    <input type="text" name="no_hp" value="{{ $petugas->no_hp }}"><br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <option value="aktif" {{ $petugas->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ $petugas->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select><br><br>

    <button type="submit">Update</button>
</form>

<br>
<a href="{{ route('admin.petugas.index') }}">Kembali</a>
@endsection