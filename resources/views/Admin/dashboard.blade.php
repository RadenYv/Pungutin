@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<h3>Dashboard Admin</h3>

@if (session('success'))
    <div style="padding: 10px; background-color: #d1e7dd; color: #0f5132; border-radius: 5px; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif

<p>Total User: {{ $totalUser ?? 0 }}</p>
<p>Total Petugas: {{ $totalPetugas ?? 0 }}</p>
<p>Total Transaksi: {{ $totalTransaksi ?? 0 }}</p>
<p>Total Kategori: {{ $totalKategori ?? 0 }}</p>

<hr>

<h4>Transaksi Terbaru</h4>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama User</th>
            <th>Petugas</th>
            <th>Kategori</th>
            <th>Berat (kg)</th>
            <th>Total Uang</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($transaksiTerbaru as $t)
        <tr>
            <td>{{ $t->id_transaksi }}</td>
            <td>{{ $t->user->nama ?? '-' }}</td>
            <td>{{ $t->petugas->nama_petugas ?? '-' }}</td>
            <td>{{ $t->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $t->berat_kg }}</td>
            <td>Rp{{ number_format($t->total_uang, 0, ',', '.') }}</td>
            <td>{{ ucfirst($t->status) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7">Belum ada transaksi</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
