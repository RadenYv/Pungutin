@extends('layouts.admin')

@section('title', 'Buat Batch')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Buat Batch</h2>
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

            <form action="{{ route('admin.batches.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_truck" class="form-label">Truck (Opsional)</label>
                    <select name="id_truck" id="id_truck" class="form-select">
                        <option value="">Tanpa Truck</option>
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
                    <label for="pickup_window" class="form-label">Waktu Pickup</label>
                    <select name="pickup_window" id="pickup_window" class="form-select" required>
                        <option value="">Pilih Waktu</option>
                        <option value="09:00-12:00">09:00 - 12:00</option>
                        <option value="13:00-16:00">13:00 - 16:00</option>
                        <option value="17:00-20:00">17:00 - 20:00</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.batches.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
