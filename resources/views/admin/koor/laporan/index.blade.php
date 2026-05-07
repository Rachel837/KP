<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div class="content py-10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="fs-3 mb-1">Manajemen Laporan Jadwal</h1>
                        <p class="mb-0">Daftar seluruh laporan jadwal kremasi.</p>
                    </div>
                    <div>
                        <a href="{{ route('laporan.create') }}" class="btn btn-primary"><i class="ti ti-plus me-2"></i> Tambah Laporan</a>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Tanggal</th>
                                <th>Waktu Tiba</th>
                                <th>Pelanggan</th>
                                <th>Ruangan</th>
                                <th>Listrik (kWh)</th>
                                <th>Solar (L)</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $index => $jadwal)
                            <tr>
                                <td class="ps-4">{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($jadwal->date)->format('dM Y') }}</td>
                                <td>{{ $jadwal->waktu_tiba }}</td>
                                <td>{{ $jadwal->pelanggan->nama ?? '-' }}</td>
                                <td>{{ $jadwal->ruangan->nama ?? '-' }}</td>
                                <td>{{ $jadwal->pemakaian_listrik ?? '-' }}</td>
                                <td>{{ $jadwal->jumlah_solar ?? '-' }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('laporan.edit', $jadwal->idreports) }}" class="btn btn-sm btn-warning">
                                            <i class="ti ti-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('laporan.destroy', $jadwal->idreports) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
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
                                <td colspan="8" class="text-center py-4">Belum ada data laporan jadwal.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
