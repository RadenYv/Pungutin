@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<h2>Tambah User</h2>

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>No HP:</label><br>
    <input type="text" name="no_hp"><br><br>

    <button type="submit">Simpan</button>
</form>

<br>
<a href="{{ route('admin.users.index') }}">Kembali</a>
@endsection