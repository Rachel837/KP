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
                        <h1 class="fs-3 mb-1">Jadwal Kremasi</h1>
                        <p class="mb-0 text-muted small">Daftar agenda pelaksanaan kremasi jenazah.</p>
                    </div>
                    <a href="{{ route('karyawan.jadwal.create') }}" class="btn btn-outline-dark btn-sm mb-1">
                        <i class="ti ti-plus me-1"></i> Tambah Jadwal
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

        <!-- Jadwal Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                 <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Nama Jenazah</th>
                                        <th>Tanggal Kremasi</th>
                                        <th>Jam Awal</th>
                                        <th>Ruangan/Mesin</th>
                                        <th>Status</th>
                                         <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jadwals as $index => $jadwal)
                                    <tr class="hover-row">
                                        <td class="ps-4">
                                            <div class="fw-semibold text-dark">{{ $jadwal->nama_pelanggan }}</div>
                                            <div class="small text-muted">{{ $jadwal->umur ? $jadwal->umur . ' Tahun' : '' }} {{ $jadwal->alamat ? '| ' . $jadwal->alamat : '' }}</div>
                                        </td>
                                        <td>
                                            <span class="text-dark">{{ \Carbon\Carbon::parse($jadwal->date)->translatedFormat('d F Y') }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $jadwal->laporan->jam_awal ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-dark fw-medium">{{ $jadwal->ruangan->nama ?? '-' }}</span>
                                        </td>
                                        <td>
                                            @if(($jadwal->picture && $jadwal->picture->foto_abu) || ($jadwal->laporan && $jadwal->laporan->lama_pembakaran))
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1">Selesai</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1">Terjadwal</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('karyawan.jadwal.edit', $jadwal->id_jadwal) }}" class="btn btn-sm btn-warning text-white">
                                                    <i class="ti ti-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('karyawan.jadwal.destroy', $jadwal->id_jadwal) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="ti ti-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <div class="mb-2"><i class="ti ti-calendar-off fs-1"></i></div>
                                            Belum ada data jadwal kremasi yang tersedia.
                                            <div class="mt-3">
                                                <a href="{{ route('karyawan.jadwal.create') }}" class="btn btn-primary btn-sm">Buat Jadwal Pertama</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-row:hover {
        background-color: #fcfcfc;
    }
    .bg-success-subtle {
        background-color: #e8f5e9 !important;
    }
    .text-success {
        color: #2e7d32 !important;
    }
    .border-success-subtle {
        border-color: #c8e6c9 !important;
    }
    .bg-warning-subtle {
        background-color: #fff8e1 !important;
    }
    .text-warning {
        color: #f57f17 !important;
    }
    .border-warning-subtle {
        border-color: #ffe082 !important;
    }
    .btn-link {
        text-decoration: none;
    }
</style>
@endsection
