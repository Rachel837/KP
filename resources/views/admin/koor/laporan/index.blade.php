<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div class="content py-10 bg-white min-vh-100">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-end pb-2 border-bottom border-2">
                    <div>
                        <h1 class="fs-3 mb-1">Laporan</h1>
                        <p class="mb-0 text-muted small">Daftar rekapan laporan almarhum.</p>
                    </div>
                    <a href="{{ route('laporan.create') }}" class="btn btn-outline-dark btn-sm mb-1">
                        <i class="ti ti-plus me-1"></i> Tambah Laporan
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Reports List grouped by Date -->
        @forelse($jadwals as $date => $group)
        <div class="mt-5 mb-4">
            <h5 class="fw-normal text-dark mb-3">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h5>
            
            <div class="report-group">
                @foreach($group as $jadwal)
                <div class="report-row py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div class="name-section">
                        <span class="fs-5 text-dark">{{ $jadwal->nama_pelanggan }}</span>
                    </div>
                    <div class="action-section d-flex gap-2">
                        <a href="{{ route('laporan.show', $jadwal->idreports) }}?download=1" target="_blank" class="btn-download px-3 py-1">
                            download
                        </a>
                        <a href="{{ route('laporan.show', $jadwal->idreports) }}?print=1" target="_blank" class="btn-print px-4 py-1">
                            print
                        </a>
                        <!-- Administrative actions (Edit/Delete) - subtle -->
                        <div class="dropdown ms-2">
                            <button class="btn btn-link btn-sm text-muted p-0" type="button" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item" href="{{ route('laporan.edit', $jadwal->idreports) }}"><i class="ti ti-edit me-2"></i> Edit</a></li>
                                <li>
                                    <form action="{{ route('laporan.destroy', $jadwal->idreports) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"><i class="ti ti-trash me-2"></i> Hapus</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center py-5 mt-5">
            <p class="text-muted fs-5">Belum ada data laporan yang tersedia.</p>
            <a href="{{ route('laporan.create') }}" class="btn btn-primary mt-2">Buat Laporan Pertama</a>
        </div>
        @endforelse
    </div>
</div>

<style>
    /* Match the aesthetic of the provided image */
    .btn-download {
        background-color: #78a083; /* Greenish button */
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .btn-download:hover {
        opacity: 0.9;
        color: white;
    }
    .btn-print {
        background-color: #8bbccc; /* Light blue button */
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .btn-print:hover {
        opacity: 0.9;
        color: white;
    }
    .report-row {
        border-color: #dee2e6 !important;
    }
    .border-bottom-2 {
        border-bottom-width: 2px !important;
    }
    .hover-row:hover {
        background-color: #fcfcfc;
    }
</style>
@endsection
