@extends('layouts.user')

@section('title', 'Buat Permintaan Penjemputan')

@section('content')

<h2>Buat Permintaan Penjemputan</h2>

<form action="{{ route('user.transaksi.store') }}" method="POST">
    @csrf

    <label>Perkiraan Berat (kg)</label><br>
    <input type="number" step="0.1" name="berat_kg" required><br><br>

    <label>Kategori Sampah</label><br>
    <select name="id_kategori" required>
        @foreach ($kategori as $k)
            <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
        @endforeach
    </select><br><br>

    <label>Alamat</label><br>
    <textarea name="alamat" required></textarea><br><br>

    <label>No HP</label><br>
    <input type="text" name="no_hp" required><br><br>

    <label>Catatan (optional)</label><br>
    <textarea name="catatan"></textarea><br><br>

    <button type="submit">Kirim Permintaan</button>
</form>

@endsection
