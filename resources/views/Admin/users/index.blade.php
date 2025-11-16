@extends('layouts.admin')

@section('title', 'Data User')

@section('content')
<h2>Data User</h2>

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
            <th>Saldo</th>
            <th>Poin</th>
            <th>Dibuat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $u)
            <tr>
                <td>{{ $u->id_user }}</td>
                <td>{{ $u->nama }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->no_hp ?? '-' }}</td>
                <td>Rp {{ number_format($u->saldo_total) }}</td>
                <td>{{ $u->poin_total }}</td>
                <td>{{ $u->created_at ? $u->created_at->format('d-m-Y') : '-' }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $u->id_user) }}">Edit</a> |
                <form action="{{ route('admin.users.destroy', $u->id_user) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;">Belum ada user</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
