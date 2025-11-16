@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')

<h2>Halo, {{ $user->nama }}</h2>

<hr>

<h3>Informasi Akun</h3>
<ul>
    <li><strong>Saldo:</strong> Rp {{ number_format($user->saldo_total) }}</li>
    <li><strong>Poin:</strong> {{ $user->poin_total }}</li>
</ul>

<hr>

<h3>Minta Penjemputan Sampah</h3>
<a href="{{ route('user.transaksi.create') }}">+ Buat Permintaan Baru</a>

<hr>

<h3>Riwayat Transaksi</h3>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Kategori</th>
            <th>Berat</th>
            <th>Total Uang</th>
            <th>Status</th>
            <th>Petugas</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($transaksi as $t)
            <tr>
                <td>{{ $t->id_transaksi }}</td>
                <td>{{ $t->kategori->nama_kategori }}</td>
                <td>{{ $t->berat_kg }} kg</td>
                <td>Rp {{ number_format($t->total_uang) }}</td>
                <td>{{ ucfirst($t->status) }}</td>
                <td>{{ $t->petugas->nama ?? '-' }}</td>
                <td>{{ $t->created_at->format('d-m-Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center;">Belum ada transaksi</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
