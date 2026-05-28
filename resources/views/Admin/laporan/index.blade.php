@extends('layouts.admin')

@section('title', 'Laporan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
@endpush

@section('content')
<div class="laporan-page">

    <div class="laporan-toolbar no-print">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h2 class="page-heading mb-1">
                    <i class="bi bi-file-earmark-bar-graph"></i> Laporan Operasional
                </h2>
                <p class="page-description">Rangkuman aktivitas pengumpulan sampah dan pengeluaran</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" type="button" onclick="window.print()">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.laporan.index') }}" class="card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control"
                               value="{{ $startDate->toDateString() }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control"
                               value="{{ $endDate->toDateString() }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="laporan-document">

        <div class="laporan-header">
            <div class="laporan-brand">
                <img src="{{ asset('images/turtle.svg') }}" alt="Pungut-in" class="laporan-logo">
                <div>
                    <h1 class="laporan-title">PUNGUT-IN</h1>
                    <div class="laporan-subtitle">Waste Collection &amp; Recycling Services</div>
                </div>
            </div>
            <div class="laporan-meta">
                <div><strong>Laporan Operasional</strong></div>
                <div class="text-muted small">Periode: {{ $startDate->format('d M Y') }} &mdash; {{ $endDate->format('d M Y') }}</div>
                <div class="text-muted small">Dicetak: {{ $generatedAt->format('d M Y, H:i') }}</div>
            </div>
        </div>

        <section class="laporan-section">
            <h3 class="laporan-section-title">Ringkasan</h3>

            <div class="row g-3">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card stat-card-primary">
                        <div class="stat-card-icon"><i class="bi bi-box-seam"></i></div>
                        <div class="stat-card-label">Total Sampah Terkumpul</div>
                        <div class="stat-card-value">{{ number_format($totalKg, 2, ',', '.') }} <small>kg</small></div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card stat-card-success">
                        <div class="stat-card-icon"><i class="bi bi-cash-stack"></i></div>
                        <div class="stat-card-label">Total Pengeluaran</div>
                        <div class="stat-card-value">Rp {{ number_format($totalUang, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card stat-card-purple">
                        <div class="stat-card-icon"><i class="bi bi-star-fill"></i></div>
                        <div class="stat-card-label">Total Poin Dibagikan</div>
                        <div class="stat-card-value">{{ number_format($totalPoin, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card stat-card-teal">
                        <div class="stat-card-icon"><i class="bi bi-check2-circle"></i></div>
                        <div class="stat-card-label">Transaksi Selesai</div>
                        <div class="stat-card-value">{{ $totalTransaksi }}</div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-3 col-sm-6">
                    <div class="metric-row">
                        <div class="metric-label">Rata-rata kg/transaksi</div>
                        <div class="metric-value">{{ number_format($avgKg, 2, ',', '.') }} kg</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="metric-row">
                        <div class="metric-label">Rata-rata pengeluaran</div>
                        <div class="metric-value">Rp {{ number_format($avgUang, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="metric-row">
                        <div class="metric-label">Batch Selesai</div>
                        <div class="metric-value">{{ $batchSelesai }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="metric-row">
                        <div class="metric-label">Transaksi Menunggu</div>
                        <div class="metric-value">{{ $transaksiMenunggu }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="laporan-section">
            <h3 class="laporan-section-title">Rincian per Kategori Sampah</h3>

            @if($perKategori->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Tidak ada data transaksi selesai pada periode ini.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table data-table laporan-table">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th class="text-end">Transaksi</th>
                                <th class="text-end">Total Berat (kg)</th>
                                <th class="text-end">Total Pengeluaran</th>
                                <th class="text-end">Poin Dibagikan</th>
                                <th class="text-end">% dari Total kg</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perKategori as $row)
                                @php
                                    $pct = $totalKg > 0 ? ($row->total_kg / $totalKg) * 100 : 0;
                                @endphp
                                <tr>
                                    <td>
                                        <span class="kategori-tag">
                                            <i class="bi bi-tag-fill"></i>
                                            {{ $row->kategori->nama_kategori ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="text-end">{{ $row->total_transaksi }}</td>
                                    <td class="text-end fw-semibold">{{ number_format($row->total_kg, 2, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($row->total_uang, 0, ',', '.') }}</td>
                                    <td class="text-end">
                                        <span class="badge-poin">{{ number_format($row->total_poin, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="pct-bar">
                                            <div class="pct-fill" style="width: {{ $pct }}%"></div>
                                            <span class="pct-label">{{ number_format($pct, 1, ',', '.') }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-total">
                                <th>TOTAL</th>
                                <th class="text-end">{{ $totalTransaksi }}</th>
                                <th class="text-end">{{ number_format($totalKg, 2, ',', '.') }}</th>
                                <th class="text-end">Rp {{ number_format($totalUang, 0, ',', '.') }}</th>
                                <th class="text-end">{{ number_format($totalPoin, 0, ',', '.') }}</th>
                                <th class="text-end">100%</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </section>

        <section class="laporan-section">
            <h3 class="laporan-section-title">Rincian Harian</h3>

            @if($perHari->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <p>Tidak ada aktivitas harian pada periode ini.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table data-table laporan-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th class="text-end">Jumlah Transaksi</th>
                                <th class="text-end">Total Berat (kg)</th>
                                <th class="text-end">Total Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perHari as $row)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                                    <td class="text-end">{{ $row->total_transaksi }}</td>
                                    <td class="text-end fw-semibold">{{ number_format($row->total_kg, 2, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($row->total_uang, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <div class="laporan-footer print-only">
            <hr>
            <div class="d-flex justify-content-between">
                <small>Pungut-in &mdash; Laporan Operasional Internal</small>
                <small>Halaman dicetak {{ $generatedAt->format('d M Y, H:i') }}</small>
            </div>
        </div>

    </div>
</div>
@endsection
