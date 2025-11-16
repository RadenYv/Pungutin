@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<h2>Tambah</h2>

<form action="{{ route('admin.kategori.store') }}" method="POST">
    @csrf
    <label>Nama Sampah:</label><br>
    <input type="text" name="nama_kategori" required><br><br>

    <label>Harga per kg:</label><br>
    <input type="text" name="harga_per_kg"  required> <br><br>

    <label>Poin per kg:</label><br>
    <input type="text" name="poin_per_kg"required> <br><br>

    <button type="submit">Simpan</button>
</form>

<br>
<a href="{{ route('admin.kategori.index') }}">Kembali</a>
@endsection