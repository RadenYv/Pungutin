@extends('layouts.admin')

@section('title', 'Kategori')
@section('content')
<h2>Kategori</h2>

@if (session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

<a href="{{ route('admin.kategori.create') }}">+ Tambah</a>
<br><br>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Sampah</th>
            <th>Harga per kg</th>
            <th>Poin per kg</th>
            <th>Dibuat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($kategori as $k)
            <tr>
                <td>{{ $k->id_kategori }}</td>
                <td>{{ $k->nama_kategori }}</td>
                <td>{{ $k->harga_per_kg }}</td>
                <td>{{ $k->poin_per_kg }}</td>
                <td>{{ $k->created_at ? $k->created_at->format('d-m-Y') : '-' }}</td>
                <td>
                    <a href="{{ route('admin.kategori.edit', $k->id_kategori) }}">Edit</a> |
                <form action="{{ route('admin.kategori.destroy', $k->id_kategori) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus petugas ini?')">Hapus</button>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;">Belum ada Petugas</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
