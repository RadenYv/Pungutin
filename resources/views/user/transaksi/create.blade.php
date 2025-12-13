@extends('layouts.user')

@section('title', 'Buat Permintaan Penjemputan')

@section('content')

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Buat Permintaan Penjemputan</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('user.transaksi.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="berat_kg" class="form-label">Perkiraan Berat (kg)</label>
                    <input type="number" step="0.1" class="form-control" id="berat_kg" name="berat_kg" required>
                </div>

                <div class="mb-3">
                    <label for="id_kategori" class="form-label">Kategori Sampah</label>
                    <select name="id_kategori" id="id_kategori" class="form-select" required>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (optional)</label>
                    <textarea class="form-control" id="catatan" name="catatan"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
            </form>
        </div>
    </div>
</div>

@endsection
