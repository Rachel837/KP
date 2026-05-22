<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div class="content py-10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                
                @if(request()->has('jadwal_id') || request()->has('manual'))
                    <!-- FORM PENGISIAN LAPORAN -->
                    <div class="mb-4">
                        <h1 class="fs-3 mb-1">Tambah Laporan Jadwal</h1>
                        <p class="text-muted">
                            @if($selectedJadwal)
                                Mengisi laporan untuk almarhum <strong>{{ $selectedJadwal->nama_pelanggan }}</strong>.
                            @else
                                Mengisi laporan jadwal baru (Input Manual).
                            @endif
                        </p>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form action="{{ route('karyawan.laporan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <input type="hidden" name="jadwal_id" value="{{ $selectedJadwal ? $selectedJadwal->idreports : '' }}">

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="nama_pelanggan" class="form-label fw-medium text-dark">Nama Almarhum</label>
                                        <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan', $selectedJadwal ? $selectedJadwal->nama_pelanggan : '') }}" required placeholder="Nama Almarhum">
                                        @error('nama_pelanggan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="alamat" class="form-label fw-medium text-dark">Alamat</label>
                                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat', $selectedJadwal ? $selectedJadwal->alamat : '') }}" placeholder="Alamat Almarhum">
                                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="umur" class="form-label fw-medium text-dark">Umur</label>
                                        <input type="text" class="form-control @error('umur') is-invalid @enderror" id="umur" name="umur" value="{{ old('umur', $selectedJadwal ? $selectedJadwal->umur : '') }}" placeholder="Contoh: 60">
                                        @error('umur')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="ruangan_id" class="form-label fw-medium text-dark">Ruangan/Mesin</label>
                                        <select class="form-select @error('ruangan_id') is-invalid @enderror" id="ruangan_id" name="ruangan_id" required>
                                            <option value="" disabled>Pilih</option>
                                            @foreach($ruangans as $ruang)
                                                <option value="{{ $ruang->id }}" {{ old('ruangan_id', $selectedJadwal ? $selectedJadwal->ruangan_id : '') == $ruang->id ? 'selected' : '' }}>{{ $ruang->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('ruangan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <hr class="my-4 text-muted">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="date" class="form-label fw-medium text-dark">Tanggal Pelaksanaan Kremasi</label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $selectedJadwal ? $selectedJadwal->date : '') }}" required>
                                        @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="waktu_tiba" class="form-label fw-medium text-dark">Waktu Tiba</label>
                                        <input type="time" class="form-control @error('waktu_tiba') is-invalid @enderror" id="waktu_tiba" name="waktu_tiba" value="{{ old('waktu_tiba') }}" required>
                                        @error('waktu_tiba')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="jam_awal" class="form-label fw-medium text-dark">Jam Mulai Kremasi</label>
                                        <input type="time" class="form-control @error('jam_awal') is-invalid @enderror" id="jam_awal" name="jam_awal" value="{{ old('jam_awal', $selectedJadwal ? substr($selectedJadwal->jam_awal, 0, 5) : '') }}" required>
                                        @error('jam_awal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="jam_akhir" class="form-label fw-medium text-dark">Jam Selesai Kremasi</label>
                                        <input type="time" class="form-control @error('jam_akhir') is-invalid @enderror" id="jam_akhir" name="jam_akhir" value="{{ old('jam_akhir') }}" required>
                                        @error('jam_akhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="jumlah_solar" class="form-label fw-medium text-dark">Pemakaian Solar (Liter)</label>
                                        <input type="number" step="0.01" class="form-control @error('jumlah_solar') is-invalid @enderror" id="jumlah_solar" name="jumlah_solar" value="{{ old('jumlah_solar') }}">
                                        @error('jumlah_solar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="lama_pembakaran" class="form-label fw-medium text-dark">Lama Waktu Pembakaran (Menit)</label>
                                        <input type="text" class="form-control @error('lama_pembakaran') is-invalid @enderror" id="lama_pembakaran" name="lama_pembakaran" value="{{ old('lama_pembakaran') }}" placeholder="Contoh: 150">
                                        @error('lama_pembakaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <hr class="my-4 text-muted">
                                <h5 class="mb-3 text-dark">Dokumentasi Foto</h5>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_permohonan" class="form-label fw-medium text-dark">Foto Bukti Surat Permohonan</label>
                                        <input type="file" class="form-control @error('foto_permohonan') is-invalid @enderror" id="foto_permohonan" name="foto_permohonan" accept="image/*">
                                        @error('foto_permohonan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_tiba" class="form-label fw-medium text-dark">Foto Jenazah Tiba</label>
                                        <input type="file" class="form-control @error('foto_tiba') is-invalid @enderror" id="foto_tiba" name="foto_tiba" accept="image/*">
                                        @error('foto_tiba')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_awal" class="form-label fw-medium text-dark">Foto Awal Pembakaran</label>
                                        <input type="file" class="form-control @error('foto_awal') is-invalid @enderror" id="foto_awal" name="foto_awal" accept="image/*">
                                        @error('foto_awal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_akhir" class="form-label fw-medium text-dark">Foto Akhir Pembakaran</label>
                                        <input type="file" class="form-control @error('foto_akhir') is-invalid @enderror" id="foto_akhir" name="foto_akhir" accept="image/*">
                                        @error('foto_akhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_tulang" class="form-label fw-medium text-dark">Foto Tulang</label>
                                        <input type="file" class="form-control @error('foto_tulang') is-invalid @enderror" id="foto_tulang" name="foto_tulang" accept="image/*">
                                        @error('foto_tulang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_abu" class="form-label fw-medium text-dark">Foto Abu</label>
                                        <input type="file" class="form-control @error('foto_abu') is-invalid @enderror" id="foto_abu" name="foto_abu" accept="image/*">
                                        @error('foto_abu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('karyawan.laporan.create') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- DAFTAR NAMA NAMA ALMARHUM -->
                    <div class="mb-4">
                        <h1 class="fs-3 mb-1">Tambah Laporan Jadwal</h1>
                        <p class="text-muted">Silakan pilih nama almarhum dari jadwal kremasi aktif di bawah ini untuk membuat laporan.</p>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title text-dark mb-0 fw-semibold">Pilih Jadwal Kremasi</h5>
                                <a href="{{ route('karyawan.laporan.create', ['manual' => 1]) }}" class="btn btn-primary">
                                    Input Manual / Jadwal Baru
                                </a>
                            </div>

                            @if($jadwals->isEmpty())
                                <div class="text-center py-5">
                                    <p class="text-muted mb-0">Tidak ada jadwal kremasi aktif (Terjadwal) saat ini.</p>
                                    <p class="text-muted small">Semua jadwal telah dilaporkan atau belum ada jadwal baru.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Almarhum</th>
                                                <th>Tanggal Kremasi</th>
                                                <th>Jam Awal</th>
                                                <th>Ruangan/Mesin</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($jadwals as $j)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('karyawan.laporan.create', ['jadwal_id' => $j->idreports]) }}" class="fw-semibold text-primary text-decoration-none fs-5">
                                                            {{ $j->nama_pelanggan }}
                                                        </a>
                                                        @if($j->umur || $j->alamat)
                                                            <div class="text-muted small">
                                                                @if($j->umur) {{ $j->umur }} Thn @endif
                                                                @if($j->alamat) | {{ $j->alamat }} @endif
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $j->date }}</td>
                                                    <td>{{ $j->jam_awal ? substr($j->jam_awal, 0, 5) : '' }} WIB</td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border px-2.5 py-1">
                                                            {{ $j->ruangan->nama ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('karyawan.laporan.create', ['jadwal_id' => $j->idreports]) }}" class="btn btn-sm btn-info text-white px-3">
                                                            Pilih & Isi Laporan
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
