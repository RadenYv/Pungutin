@extends('layouts.admin')

@section('title', 'Edit Penjemputan')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Edit Penjemputan</h2>
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

            <form action="{{ route('admin.transaksi.update', $transaksi->id_transaksi) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_kategori" class="form-label">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-select">
                        @foreach($kategori as $k)
                            <option value="{{ $k->id_kategori }}" {{ $transaksi->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_batch" class="form-label">Batch</label>
                    <select name="id_batch" id="id_batch" class="form-select">
                        <option value="">-</option>
                        @foreach($batches as $b)
                            <option value="{{ $b->id_batch }}" {{ $transaksi->id_batch == $b->id_batch ? 'selected' : '' }}>
                                #{{ $b->id_batch }} - {{ $b->tanggal }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_pickup" class="form-label">Tanggal Pickup</label>
                    <input type="date" class="form-control" id="tanggal_pickup" name="tanggal_pickup" value="{{ old('tanggal_pickup', $transaksi->tanggal_pickup) }}">
                </div>

                <div class="mb-3">
                    <label for="pickup_window" class="form-label">Pickup Window</label>
                    <input type="text" class="form-control" id="pickup_window" name="pickup_window" value="{{ old('pickup_window', $transaksi->pickup_window) }}">
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $transaksi->alamat) }}">
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $transaksi->no_hp) }}">
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan">{{ old('catatan', $transaksi->catatan) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="menunggu"    {{ $transaksi->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="dalam_batch" {{ $transaksi->status === 'dalam_batch' ? 'selected' : '' }}>Dalam Batch</option>
                        <option value="dijemput"    {{ $transaksi->status === 'dijemput' ? 'selected' : '' }}>Dijemput</option>
                        <option value="selesai"     {{ $transaksi->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
