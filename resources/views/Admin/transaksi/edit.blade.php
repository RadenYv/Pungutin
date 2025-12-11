@extends('layouts.admin')

@section('title', 'Edit Transaksi')

@section('content')
<h2>Edit Transaksi</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.transaksi.update', $transaksi->id_transaksi) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Kategori:</label>
    <select name="id_kategori">
        @foreach($kategori as $k)
            <option value="{{ $k->id_kategori }}" {{ $transaksi->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Batch:</label>
    <select name="id_batch">
        <option value="">-</option>
        @foreach($batches as $b)
            <option value="{{ $b->id_batch }}" {{ $transaksi->id_batch == $b->id_batch ? 'selected' : '' }}>
                #{{ $b->id_batch }} - {{ $b->tanggal }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Tanggal Pickup:</label>
    <input type="date" name="tanggal_pickup" value="{{ old('tanggal_pickup', $transaksi->tanggal_pickup) }}">
    <br><br>

    <label>Pickup Window:</label>
    <input type="text" name="pickup_window" value="{{ old('pickup_window', $transaksi->pickup_window) }}">
    <br><br>

    <label>Alamat:</label>
    <input type="text" name="alamat" value="{{ old('alamat', $transaksi->alamat) }}">
    <br><br>

    <label>No HP:</label>
    <input type="text" name="no_hp" value="{{ old('no_hp', $transaksi->no_hp) }}">
    <br><br>

    <label>Catatan:</label>
    <textarea name="catatan">{{ old('catatan', $transaksi->catatan) }}</textarea>
    <br><br>

    <label>Status:</label>
    <select name="status">
        <option value="menunggu"    {{ $transaksi->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
        <option value="dalam_batch" {{ $transaksi->status === 'dalam_batch' ? 'selected' : '' }}>Dalam Batch</option>
        <option value="dijemput"    {{ $transaksi->status === 'dijemput' ? 'selected' : '' }}>Dijemput</option>
        <option value="selesai"     {{ $transaksi->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
    </select>
    <br><br>

    <button type="submit">Simpan</button>
</form>

@endsection
