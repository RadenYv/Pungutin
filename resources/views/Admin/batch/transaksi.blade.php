@extends('layouts.admin')

@section('title', 'Transaksi Batch')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/batch-detail.css') }}">
@endpush

@section('content')
<div class="batch-header">
    <h2>Transaksi Dalam Batch #{{ $batch->id_batch }}</h2>
</div>

<div class="batch-info">
    <p><strong>Tanggal:</strong> {{ $batch->tanggal }}</p>
    <p><strong>Waktu:</strong> {{ $batch->pickup_window }}</p>
</div>

<h4>Petugas Batch</h4>
<ul class="petugas-list">
    @if($batch->team)
        @foreach($batch->team->members as $m)
            <li class="petugas-badge">
                {{ $m->petugas->nama }} 
                <span class="petugas-role">({{ $m->role }})</span>
            </li>
        @endforeach
    @else
        <li class="text-muted">-</li>
    @endif
</ul>

<h4>Daftar Transaksi</h4>

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
                <td>#{{ $t->id_transaksi }}</td>
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
