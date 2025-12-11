@extends('layouts.admin')

@section('title', 'Buat Batch')

@section('content')
<h2>Buat Batch</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.batches.store') }}" method="POST">
    @csrf

    <label>Truck (Opsional):</label>
    <select name="id_truck">
        <option value="">Tanpa Truck</option>
        @foreach($trucks as $t)
            <option value="{{ $t->id_truck }}">{{ $t->nama }} ({{ $t->plat_nomor }})</option>
        @endforeach
    </select>
    <br><br>

    <label>Tanggal:</label>
    <input type="date" name="tanggal" required>
    <br><br>

    <label>Waktu Pickup:</label>
    <select name="pickup_window" required>
        <option value="">Pilih Waktu</option>
        <option value="09:00-12:00">09:00 - 12:00</option>
        <option value="13:00-16:00">13:00 - 16:00</option>
        <option value="17:00-20:00">17:00 - 20:00</option>
    </select>
    <br><br>

    <button type="submit">Simpan</button>
</form>

@endsection
