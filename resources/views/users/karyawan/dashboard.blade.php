<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div class="content py-10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="mb-4">
                    <h1 class="fs-3 mb-1">Dashboard {{ auth()->user()->role->nama === 'koor' ? 'Koordinator' : 'Karyawan' }}</h1>
                    <p>Selamat datang! Berikut adalah jadwal kremasi untuk 1 minggu ke depan ({{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}).</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Tanggal Kremasi</th>
                                        <th>Jam Awal - Akhir</th>
                                        <th>Nama Jenazah</th>
                                        <th>Ruangan</th>
                                        <th class="text-end pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jadwals as $index => $jadwal)
                                    <tr>
                                        <td class="ps-4">{{ \Carbon\Carbon::parse($jadwal->date)->format('d F Y') }}</td>
                                        <td>{{ $jadwal->laporan->jam_awal ?? '-' }} - {{ $jadwal->laporan->jam_akhir ?? '-' }}</td>
                                        <td>{{ $jadwal->nama_pelanggan ?? '-' }}</td>
                                        <td>{{ $jadwal->ruangan->nama ?? '-' }}</td>
                                        <td class="text-end pe-4">
                                            @if(($jadwal->picture && $jadwal->picture->foto_abu) || ($jadwal->laporan && $jadwal->laporan->lama_pembakaran))
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Terjadwal</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Tidak ada jadwal kremasi untuk 1 minggu ke depan.</td>
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
@endsection
