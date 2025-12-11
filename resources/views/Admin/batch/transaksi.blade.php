@extends('layouts.admin')

@section('title', 'Transaksi Batch')

@section('content')
<h2>Transaksi Dalam Batch {{ $batch->id_batch }}</h2>

<p><strong>Tanggal:</strong> {{ $batch->tanggal }}</p>
<p><strong>Waktu:</strong> {{ $batch->start_time }} - {{ $batch->end_time }}</p>

<h4>Petugas Batch:</h4>
<ul>
    @if($batch->team)
        @foreach($batch->team->members as $m)
            <li>{{ $m->petugas->nama }} ({{ $m->role }})</li>
        @endforeach
    @else
        <li>-</li>
    @endif
    </ul>

<h4>Daftar Transaksi:</h4>

<div class="table-wrapper">
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Kategori</th>
            <th>Berat</th>
            <th>Alamat</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($batch->transaksi as $t)
        <tr>
            <td>{{ $t->id_transaksi }}</td>
            <td>{{ $t->user->nama }}</td>
            <td>{{ $t->kategori->nama_kategori }}</td>
            <td>{{ $t->berat_kg }} kg</td>
            <td>{{ $t->alamat }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

@endsection
