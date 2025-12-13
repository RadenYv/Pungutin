@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Edit User</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->nama }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $user->no_hp }}">
                </div>

                <div class="mb-3">
                    <label for="saldo_total" class="form-label">Saldo</label>
                    <input type="number" class="form-control" id="saldo_total" name="saldo_total" value="{{ $user->saldo_total }}">
                </div>
                
                <div class="mb-3">
                    <label for="poin_total" class="form-label">Poin</label>
                    <input type="number" class="form-control" id="poin_total" name="poin_total" value="{{ $user->poin_total }}">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
