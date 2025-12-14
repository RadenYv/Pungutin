@extends('layouts.admin')

@section('title', 'Profil Admin')

@push('styles')
	<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
	<div class="profile-wrapper">
		<div class="profile-card">
			<div class="profile-left">
				<div class="profile-avatar">
					@if(!empty($admin->avatar))
						<img src="{{ asset('storage/' . $admin->avatar) }}" alt="avatar">
					@else
						<img src="{{ asset('images/profile .jpg') }}" alt="avatar">
					@endif
					<button class="avatar-edit" title="Ubah avatar"><i class="bi bi-camera"></i></button>
				</div>

				<div class="profile-upload-group">
					<div class="upload-box">Upload Foto</div>
					<div class="upload-box">Ganti Background</div>
				</div>
			</div>

			<div class="profile-right">
				<div class="profile-info">
					<div class="profile-field">
						<label>Nama</label>
						<span>{{ $admin->nama ?? '-' }}</span>
					</div>

					<div class="profile-field">
						<label>Email</label>
						<span>{{ $admin->email ?? '-' }}</span>
					</div>

					<div class="profile-field">
						<label>No. HP</label>
						<span>{{ $admin->no_hp ?? '-' }}</span>
					</div>

					<div class="profile-field">
						<label>Role</label>
						<span>{{ $admin->role ?? 'admin' }}</span>
					</div>
				</div>

				<div class="profile-actions">
					<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
					<a href="#" class="btn btn-edit-profile">Edit Profil</a>
				</div>
			</div>
		</div>
	</div>
@endsection

