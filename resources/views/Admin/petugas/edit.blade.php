@extends('layouts.admin')

@section('title', 'Edit Petugas')

@section('content')
<h2>Edit Petugas</h2>

<form action="{{ route('admin.petugas.update', $p->id_petugas) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama:</label><br>
    <input type="text" name="nama" value="{{ $p->nama }}" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="{{ $p->email }}" required><br><br>

    <label>No HP:</label><br>
    <input type="text" name="no_hp" value="{{ $p->no_hp }}"><br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <option value="aktif" {{ $p->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ $p->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select><br><br>

    <button type="submit">Update</button>
</form>

<br>
<a href="{{ route('admin.petugas.index') }}">Kembali</a>
@endsection