@extends('layouts.user')

@section('title', 'Detail Transaksi')

@section('content')

<h2>Detail Transaksi #{{ $transaksi->id_transaksi }}</h2>

<ul>
    <li><strong>Kategori:</strong> {{ $transaksi->kategori->nama_kategori }}</li>
    <li><strong>Berat User:</strong> {{ $transaksi->berat_kg }} kg</li>
    <li><strong>Total Uang:</strong> Rp {{ number_format($transaksi->total_uang) }}</li>
    <li><strong>Poin Didapat:</strong> {{ $transaksi->poin_didapat }}</li>
    <li><strong>Status:</strong> {{ ucfirst($transaksi->status) }}</li>
    <li><strong>Alamat:</strong> {{ $transaksi->alamat }}</li>
    <li><strong>No HP:</strong> {{ $transaksi->no_hp }}</li>
    <li><strong>Catatan:</strong> {{ $transaksi->catatan ?? '-' }}</li>

    @if ($transaksi->petugas)
        <li><strong>Petugas:</strong> {{ $transaksi->petugas->nama }}</li>
    @endif
</ul>

<a href="{{ route('user.transaksi.index') }}">← Kembali</a>

@endsection
