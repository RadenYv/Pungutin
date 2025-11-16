@extends('layouts.admin')

@section('title', 'Tambah Petugas')

@section('content')
<h2>Tambah Petugas</h2>

<form action="{{ route('admin.petugas.store') }}" method="POST">
    @csrf
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>No HP:</label><br>
    <input type="text" name="no_hp"><br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <option value="aktif">Aktif</option>
        <option value="nonaktif">Nonaktif</option>
    </select><br><br>

    <button type="submit">Simpan</button>
</form>


<br>
<a href="{{ route('admin.petugas.index') }}">Kembali</a>
@endsection
