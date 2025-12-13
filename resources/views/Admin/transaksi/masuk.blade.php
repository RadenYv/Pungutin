@extends('layouts.admin')

@section('title', 'Transaksi Masuk')

@section('content')
<h2>Transaksi Menunggu</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Kategori</th>
            <th>Berat (kg)</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($transaksi as $t)
        <tr>
            <td>{{ $t->id_transaksi }}</td>
            <td>{{ $t->user->nama }}</td>
            <td>{{ $t->kategori->nama_kategori }}</td>
            <td>{{ $t->berat_kg }}</td>
            <td>{{ $t->alamat }}</td>
            <td>
                <form action="{{ route('admin.transaksi.assignBatch', $t->id_transaksi) }}" method="POST">
                    @csrf
                    <select name="id_batch" class="form-select" required>
                        <option value="">Pilih Batch</option>
                        @foreach($batches as $b)
                            <option value="{{ $b->id_batch }}">
                                {{ $b->tanggal }} ({{ $b->start_time }} - {{ $b->end_time }})
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary mt-2">Masukkan</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
@extends('layouts.admin')

@section('title', 'Transaksi Masuk')

@section('content')
<h2>Transaksi Menunggu</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Kategori</th>
            <th>Berat (kg)</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($transaksi as $t)
        <tr>
            <td>{{ $t->id_transaksi }}</td>
            <td>{{ $t->user->nama }}</td>
            <td>{{ $t->kategori->nama_kategori }}</td>
            <td>{{ $t->berat_kg }}</td>
            <td>{{ $t->alamat }}</td>
            <td>
                <form action="{{ route('admin.transaksi.assignBatch', $t->id_transaksi) }}" method="POST">
                    @csrf
                    <select name="id_batch" class="form-select" required>
                        <option value="">Pilih Batch</option>
                        @foreach($batches as $b)
                            <option value="{{ $b->id_batch }}">
                                {{ $b->tanggal }} ({{ $b->start_time }} - {{ $b->end_time }})
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary mt-2">Masukkan</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
