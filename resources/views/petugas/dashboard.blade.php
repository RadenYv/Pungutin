@extends('layouts.petugas')

@section('title, "Dashboard petugas')

@section('content')
<h2>Welcum, {{ $petugas->nama }}</h2>

<hr>

<h3>Daftar Penjemputan Anda</h3>

<table border="1" cellpadding="8" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Kategori</th>
            <th>Berat</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($transaksi as $t)
        <tr>
            <td>{{ $t->id_transaksi }}</td>
            <td>{{ $t->kategori->nama_kategori }}</td>
            <td>{{ $t->berat_kg }} kg</td>
            <td>{{ ucfirst($t->status) }}</td>
            <td>{{ $t->created_at->format('d-m-Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;">Tidak ada Penjemputan</td></tr>
        @endforelse
    </tbody>
</table>
@endsection


