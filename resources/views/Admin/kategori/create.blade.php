@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Tambah Kategori</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Sampah</label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                </div>

                <div class="mb-3">
                    <label for="harga_per_kg" class="form-label">Harga per kg</label>
                    <input type="text" class="form-control" id="harga_per_kg" name="harga_per_kg" required>
                </div>

                <div class="mb-3">
                    <label for="poin_per_kg" class="form-label">Poin per kg</label>
                    <input type="text" class="form-control" id="poin_per_kg" name="poin_per_kg" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection