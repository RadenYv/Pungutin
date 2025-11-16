@extends('layouts.user')

@section('title', 'Transaksi Saya')

@section('content')

<h2>Transaksi Saya</h2>

<a href="{{ route('user.transaksi.create') }}">+ Permintaan Penjemputan Baru</a>

<hr>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if ($transaksi->isEmpty())
    <p>Belum ada transaksi.</p>
@else
<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
        <th>ID</th>
        <th>Kategori</th>
        <th>Berat</th>
        <th>Status</th>
        <th>Detail</th>
    </tr>

    @foreach ($transaksi as $t)
    <tr>
        <td>{{ $t->id_transaksi }}</td>
        <td>{{ $t->kategori->nama_kategori }}</td>
        <td>{{ $t->berat_kg }} kg</td>
        <td>{{ ucfirst($t->status) }}</td>
        <td>
            <a href="{{ route('user.transaksi.show', $t->id_transaksi) }}">Lihat</a>
        </td>
    </tr>
    @endforeach
</table>
@endif

@endsection
