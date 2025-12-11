@extends('layouts.petugas')

@section('title', 'Penjemputan Tugas')

@section('content')

<h2>Transaksi yang Harus Dijemput</h2>

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

<div class="table-wrapper">
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Kategori</th>
            <th>Berat Estimasi</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($transaksi as $t)
            <tr>
                <td>{{ $t->id_transaksi }}</td>
                <td>{{ $t->kategori->nama_kategori }}</td>
                <td>{{ $t->berat_kg }} kg</td>
                <td>{{ $t->alamat }}</td>
                <td>{{ $t->no_hp }}</td>

                <td>
                    @if ($t->berat_kg_final === null)
                        {{-- Belum update berat --}}
                        <form action="{{ route('petugas.updateBerat', $t->id_transaksi) }}" method="POST">
                            @csrf
                            <input type="number" name="berat_kg_final" placeholder="Berat aktual (kg)">
                            <button type="submit">Update Berat</button>
                        </form>
                    @else
                        {{-- Sudah update --}}
                        <form action="{{ route('petugas.selesaikan', $t->id_transaksi) }}" method="POST">
                            @csrf
                            <button type="submit">Selesaikan</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada tugas penjemputan</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

@endsection
