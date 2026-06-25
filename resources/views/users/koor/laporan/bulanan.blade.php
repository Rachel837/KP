<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div class="content py-10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="fs-3 mb-1">Rekap Laporan Bulanan {{ $selected_ruangan ? '- ' . $selected_ruangan->nama : '' }}</h1>
                        <p class="mb-0">Aktivitas kremasi dan pemakaian solar per mesin.</p>
                    </div>
                    @if($selected_ruangan)
                    <div>
                        <a href="{{ route('laporan.bulanan') }}" class="btn btn-outline-primary"><i class="ti ti-arrow-left me-2"></i> Pilih Mesin Lain</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if(!$selected_ruangan)
        <div class="row g-4 mt-2">
            @foreach($ruangans as $ruang)
            <div class="col-md-6">
                <a href="{{ route('laporan.bulanan', ['ruangan_id' => $ruang->id]) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm hover-lift transition">
                        <div class="card-body p-5 text-center">
                            <div class="icon-shape icon-xxl bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="ti ti-settings fs-1"></i>
                            </div>
                            <h3 class="fs-4 mb-2">{{ $ruang->nama }}</h3>
                            <p class="text-muted mb-0">Klik untuk melihat rekap laporan bulanan untuk {{ $ruang->nama }}.</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        @php
            $bulanIndo = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
        @endphp
        <!-- Filter Form -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('laporan.bulanan') }}" method="GET" class="row gx-3 align-items-end">
                    <input type="hidden" name="ruangan_id" value="{{ $selected_ruangan->id }}">
                    <div class="col-md-4">
                        <label for="bulan" class="form-label fw-bold text-muted mb-1">Bulan</label>
                        <select name="bulan" id="bulan" class="form-select">
                            <option value="">-- Semua Bulan --</option>
                            @for($m=1; $m<=12; ++$m)
                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                    {{ $bulanIndo[$m] }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="tahun" class="form-label fw-bold text-muted mb-1">Tahun</label>
                        <select name="tahun" id="tahun" class="form-select">
                            <option value="">-- Semua Tahun --</option>
                            @forelse($availableYears as $y)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @empty
                                <option value="{{ date('Y') }}" {{ request('tahun') == date('Y') ? 'selected' : '' }}>
                                    {{ date('Y') }}
                                </option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary me-2"><i class="ti ti-filter"></i> Filter</button>
                        <a href="{{ route('laporan.bulanan', ['ruangan_id' => $selected_ruangan->id]) }}" class="btn btn-outline-secondary"><i class="ti ti-refresh"></i> Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Tgl Pembakaran</th>
                                <th>Nama Jenazah</th>
                                <th>Alamat</th>
                                <th>Usia</th>
                                <th>Waktu Pembakaran</th>
                                <th>Pemakaian Solar</th>
                                <th>Pemakaian Listrik</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $index => $report)
                            <tr>
                                <td class="ps-4">{{ \Carbon\Carbon::parse($report->date)->format('d/m/Y') }}</td>
                                <td class="fw-bold">{{ $report->nama_pelanggan }}</td>
                                <td>{{ $report->alamat ?? '-' }}</td>
                                <td>{{ $report->umur ?? '-' }} Thn</td>
                                <td>{{ $report->laporan->lama_pembakaran ?? '-' }} Menit</td>
                                <td>{{ $report->laporan->jumlah_solar ?? '0' }} L</td>
                                <td>{{ $report->laporan->pemakaian_listrik ? number_format($report->laporan->pemakaian_listrik, 2) . ' kWH' : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data laporan untuk {{ $selected_ruangan->nama }}.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if(isset($summary) && $summary->count() > 0)
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">Rekap Bulanan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Total Pemakaian Solar</th>
                                <th>Total Pemakaian Listrik</th>
                                <th>Biaya Solar</th>
                                <th>Biaya Listrik</th>
                                <th>Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($summary as $sum)
                            <tr>
                                <td class="ps-4 fw-bold text-primary" style="font-size: 15px;">
                                    {{ number_format($sum->total_pemakaian_solar, 2) }} Liter
                                </td>
                                <td class="fw-bold text-warning" style="font-size: 15px;">
                                    {{ number_format($sum->total_pemakaian_listrik, 2) }} kWH
                                </td>
                                <td class="fw-bold text-success" style="font-size: 15px;">
                                    Rp {{ number_format($sum->biaya_solar, 0, ',', '.') }}
                                </td>
                                <td class="fw-bold text-danger" style="font-size: 15px;">
                                    Rp {{ number_format($sum->biaya_listrik, 0, ',', '.') }}
                                </td>
                                <td class="fw-bold text-dark" style="font-size: 15px;">
                                    Rp {{ number_format($sum->total_biaya, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>

<style>
    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .transition {
        transition: all 0.3s ease;
    }
</style>
@endsection
