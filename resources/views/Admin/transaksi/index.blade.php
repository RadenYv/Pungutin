@extends('layouts.admin')

@section('title', 'Data Transaksi')

@section('content')
<h2>Data Transaksi</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Petugas</th>
            <th>Kategori</th>
            <th>Berat (kg)</th>
            <th>Total Uang</th>
            <th>Poin</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Assign</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($transaksi as $item)
        <tr>
            <td>{{ $item->id_transaksi }}</td>

            <td>{{ $item->user->nama ?? '-' }}</td>

            <td>
                @if ($item->id_petugas)
                    {{ $item->petugas->nama }}
                @else
                    -
                @endif
            </td>

            <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>

            <td>{{ number_format($item->berat_kg, 2) }}</td>

            <td>Rp {{ number_format($item->total_uang, 0, ',', '.') }}</td>

            <td>{{ $item->poin_didapat }}</td>

            <td>
                @if ($item->status == 'menunggu')
                    <span style="color: orange;">Menunggu</span>
                @elseif ($item->status == 'dijemput')
                    <span style="color: blue;">Dijemput</span>
                @else
                    <span style="color: green;">Selesai</span>
                @endif
            </td>

            <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>

            <td>
                @if(!$item->id_petugas)
                    <form action="{{ route('admin.transaksi.assign', $item->id_transaksi) }}" method="POST">
                        @csrf
                        <select name="id_petugas" required>
                            <option value="">Pilih</option>
                            @foreach($petugas as $p)
                                <option value="{{ $p->id_petugas }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        <button type="submit">Assign</button>
                    </form>

                @else
                
                @endif
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="11" style="text-align:center;">Belum ada transaksi</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
