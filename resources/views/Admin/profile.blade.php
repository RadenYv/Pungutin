@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
    <div class="container px-4 admin-profile">
        <div class="card profile-card">
            <div class="avatar">
                @if(!empty($admin->avatar))
                    <img src="{{ asset('storage/' . $admin->avatar) }}" alt="avatar">
                @else
                    <img src="{{ asset('images/profile .jpg') }}" alt="avatar">
                @endif
            </div>

            <div class="profile-info">
                <h3>{{ $admin->nama ?? 'Admin' }}</h3>
                <div class="meta">Administrator</div>

                <div class="profile-divider"></div>

                <dl class="row">
                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $admin->email ?? '-' }}</dd>

                    <dt class="col-sm-3">No. HP</dt>
                    <dd class="col-sm-9">{{ $admin->no_hp ?? '-' }}</dd>

                    <dt class="col-sm-3">Role</dt>
                    <dd class="col-sm-9">{{ $admin->role ?? 'admin' }}</dd>
                </dl>

                <div class="actions">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush
