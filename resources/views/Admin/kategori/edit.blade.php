@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<h2>Edit Kategori</h2>

<form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama Sampah:</label><br>
    <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required><br><br>

    <label>Harga per kg:</label><br>
    <input type="text" name="harga_per_kg" value="{{ $kategori->harga_per_kg }}" required><br><br>

    <label>Poin per kg:</label><br>
    <input type="text" name="poin_per_kg" value="{{ $kategori->poin_per_kg }}" required><br><br>

    <button type="submit">Update</button>
</form>

<br>
<a href="{{ route('admin.kategori.index') }}">Kembali</a>
@endsection
