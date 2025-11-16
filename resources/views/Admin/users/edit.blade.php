@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<h2>Edit User</h2>

<form action="{{ route('admin.users.update', $user->id_user) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama:</label><br>
    <input type="text" name="nama" value="{{ $user->nama }}" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="{{ $user->email }}" required><br><br>

    <label>No HP:</label><br>
    <input type="text" name="no_hp" value="{{ $user->no_hp }}"><br><br>

    <label>Saldo:</label><br>
    <input type="number" name="saldo_total" value="{{ $user->saldo_total }}"><br><br>
    
    <label>Poin:</label><br>
    <input type="number" name="poin_total" value="{{ $user->poin_total }}"><br><br>

    <button type="submit">Update</button>
</form>

<br>
<a href="{{ route('admin.users.index') }}">Kembali</a>
@endsection
