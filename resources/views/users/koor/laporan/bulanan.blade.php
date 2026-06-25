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
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data laporan untuk {{ $selected_ruangan->nama }}.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
