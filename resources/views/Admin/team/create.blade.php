@extends('layouts.admin')

@section('title', 'Buat Team')

@section('content')
<h2>Buat Team</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.teams.store') }}" method="POST">
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

    <label>Driver:</label>
    <select name="driver" required>
        <option value="">Pilih Driver</option>
        @foreach($petugas as $p)
            <option value="{{ $p->id_petugas }}">{{ $p->nama }}</option>
        @endforeach
    </select>
    <br><br>

    <label>Co-Driver:</label>
    <select name="co_driver" required>
        <option value="">Pilih Co-Driver</option>
        @foreach($petugas as $p)
            <option value="{{ $p->id_petugas }}">{{ $p->nama }}</option>
        @endforeach
    </select>
    <br><br>

    <button type="submit">Simpan</button>
</form>
@endsection
