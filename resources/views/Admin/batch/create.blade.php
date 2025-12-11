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

    <label>Truck:</label>
    <select name="id_truck" required>
        <option value="">Pilih Truck</option>
        @foreach($trucks as $t)
            <option value="{{ $t->id_truck }}">{{ $t->nama }} ({{ $t->plat_nomor }})</option>
        @endforeach
    </select>
    <br><br>

    <label>Tanggal:</label>
    <input type="date" name="tanggal" required>
    <br><br>

    <button type="submit">Simpan</button>
</form>

@endsection
