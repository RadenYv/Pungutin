@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
    <div class="container px-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Profil Admin</h3>

                <dl class="row">
                    <dt class="col-sm-3">Nama</dt>
                    <dd class="col-sm-9">{{ $admin->nama ?? '-' }}</dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $admin->email ?? '-' }}</dd>

                    <dt class="col-sm-3">Role</dt>
                    <dd class="col-sm-9">{{ $admin->role ?? 'admin' }}</dd>

                    <dt class="col-sm-3">No. HP</dt>
                    <dd class="col-sm-9">{{ $admin->no_hp ?? '-' }}</dd>
                </dl>

                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
