@extends('layouts.admin')

@section('title', 'Data Petugas')
@section('content')
<h2>Data Petugas</h2>

@if (session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

<a href="{{ route('admin.users.create') }}">+ Tambah User</a>
<br><br>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Status</th>
            <th>Dibuat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($petugas as $p)
            <tr>
                <td>{{ $p->id_petugas }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->no_hp ?? '-' }}</td>
                <td>{{ $p->status }}</td>
                <td>{{ $p->created_at ? $p->created_at->format('d-m-Y') : '-' }}</td>
                <td>
                    <a href="{{ route('admin.petugas.edit', $p->id_petugas) }}">Edit</a> |
                <form action="{{ route('admin.petugas.destroy', $p->id_petugas) }}" method="POST" style="display:inline;">
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
