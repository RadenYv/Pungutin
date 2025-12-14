@extends('layouts.admin')

@section('title', 'Buat Team')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Buat Team</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.teams.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_truck" class="form-label">Truck</label>
                    <select name="id_truck" id="id_truck" class="form-select" required>
                        <option value="">Pilih Truck</option>
                        @foreach($trucks as $t)
                            <option value="{{ $t->id_truck }}">{{ $t->nama }} ({{ $t->plat_nomor }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                </div>

                <div class="mb-3">
                    <label for="driver" class="form-label">Driver</label>
                    <select name="driver" id="driver" class="form-select" required>
                        <option value="">Pilih Driver</option>
                        @foreach($petugas as $p)
                            <option value="{{ $p->id_petugas }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="co_driver" class="form-label">Co-Driver (Opsional)</label>
                    <select name="co_driver" id="co_driver" class="form-select">
                        <option value="">Pilih Co-Driver</option>
                        @foreach($petugas as $p)
                            <option value="{{ $p->id_petugas }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection