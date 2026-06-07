<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div class="content py-10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="mb-4">
                    <h1 class="fs-3 mb-1">Edit Laporan Jadwal</h1>
                    <p>Ubah detail informasi laporan jadwal kremasi.</p>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('karyawan.laporan.update', $laporan->idreports) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <h5 class="mb-3 text-dark fw-bold">Data Jenazah & Penanggung Jawab</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_jenazah" class="form-label fw-medium text-dark">Nama Jenazah (Almarhum)</label>
                                    <input type="text" class="form-control @error('nama_jenazah') is-invalid @enderror" id="nama_jenazah" name="nama_jenazah" value="{{ old('nama_jenazah', $laporan->pelanggan->nama ?? $laporan->nama_pelanggan) }}" required placeholder="Nama Jenazah">
                                    @error('nama_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="usia_jenazah" class="form-label fw-medium text-dark">Usia Jenazah (Tahun)</label>
                                    <input type="number" class="form-control @error('usia_jenazah') is-invalid @enderror" id="usia_jenazah" name="usia_jenazah" value="{{ old('usia_jenazah', $laporan->pelanggan->usia ?? $laporan->umur) }}" required placeholder="Contoh: 60">
                                    @error('usia_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir_jenazah" class="form-label fw-medium text-dark">Tempat Lahir Jenazah</label>
                                    <input type="text" class="form-control @error('tempat_lahir_jenazah') is-invalid @enderror" id="tempat_lahir_jenazah" name="tempat_lahir_jenazah" value="{{ old('tempat_lahir_jenazah', $laporan->pelanggan->tempat_lahir ?? '') }}" required placeholder="Tempat Lahir Jenazah">
                                    @error('tempat_lahir_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir_jenazah" class="form-label fw-medium text-dark">Tanggal Lahir Jenazah</label>
                                    <input type="date" class="form-control @error('tanggal_lahir_jenazah') is-invalid @enderror" id="tanggal_lahir_jenazah" name="tanggal_lahir_jenazah" value="{{ old('tanggal_lahir_jenazah', $laporan->pelanggan->tanggal_lahir ?? '') }}" required>
                                    @error('tanggal_lahir_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_penanggung_jawab" class="form-label fw-medium text-dark">Nama Penanggung Jawab Jenazah</label>
                                    <input type="text" class="form-control @error('nama_penanggung_jawab') is-invalid @enderror" id="nama_penanggung_jawab" name="nama_penanggung_jawab" value="{{ old('nama_penanggung_jawab', $laporan->pelanggan->penannggung_jawab ?? $laporan->pelanggan->penanggung_jawab ?? '') }}" required placeholder="Nama Penanggung Jawab">
                                    @error('nama_penanggung_jawab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon_penanggung_jawab" class="form-label fw-medium text-dark">No. Telepon Penanggung Jawab</label>
                                    <input type="text" class="form-control @error('no_telepon_penanggung_jawab') is-invalid @enderror" id="no_telepon_penanggung_jawab" name="no_telepon_penanggung_jawab" value="{{ old('no_telepon_penanggung_jawab', $laporan->pelanggan->no_telepon ?? '') }}" required placeholder="Contoh: 08123456789">
                                    @error('no_telepon_penanggung_jawab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <hr class="my-4 text-muted">
                            <h5 class="mb-3 text-dark fw-bold">Detail Pelaksanaan Laporan & Jadwal</h5>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="alamat" class="form-label fw-medium text-dark">Alamat Almarhum</label>
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat', $laporan->alamat) }}" placeholder="Alamat Almarhum">
                                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="ruangan_id" class="form-label fw-medium text-dark">Ruangan</label>
                                    <select class="form-select @error('ruangan_id') is-invalid @enderror" id="ruangan_id" name="ruangan_id" required>
                                        @foreach($ruangans as $ruang)
                                            <option value="{{ $ruang->id }}" {{ old('ruangan_id', $laporan->ruangan_id) == $ruang->id ? 'selected' : '' }}>{{ $ruang->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('ruangan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date" class="form-label fw-medium text-dark">Tanggal Pelaksanaan Kremasi</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $laporan->date) }}" required>
                                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="waktu_tiba" class="form-label fw-medium text-dark">Waktu Tiba</label>
                                    <input type="time" class="form-control @error('waktu_tiba') is-invalid @enderror" id="waktu_tiba" name="waktu_tiba" value="{{ old('waktu_tiba', $laporan->waktu_tiba ? substr($laporan->waktu_tiba, 0, 5) : '') }}" required>
                                    @error('waktu_tiba')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jam_awal" class="form-label fw-medium text-dark">Jam Mulai Kremasi</label>
                                    <input type="time" class="form-control @error('jam_awal') is-invalid @enderror" id="jam_awal" name="jam_awal" value="{{ old('jam_awal', $laporan->jam_awal ? substr($laporan->jam_awal, 0, 5) : '') }}" required>
                                    @error('jam_awal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="jam_akhir" class="form-label fw-medium text-dark">Jam Selesai Kremasi</label>
                                    <input type="time" class="form-control @error('jam_akhir') is-invalid @enderror" id="jam_akhir" name="jam_akhir" value="{{ old('jam_akhir', $laporan->jam_akhir ? substr($laporan->jam_akhir, 0, 5) : '') }}" required>
                                    @error('jam_akhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="jumlah_solar" class="form-label fw-medium text-dark">Pemakaian Solar (Liter)</label>
                                    <input type="number" step="0.01" class="form-control @error('jumlah_solar') is-invalid @enderror" id="jumlah_solar" name="jumlah_solar" value="{{ old('jumlah_solar', $laporan->jumlah_solar) }}" required placeholder="Contoh: 50.5">
                                    @error('jumlah_solar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-3">Dokumentasi Foto</h5>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="foto_permohonan" class="form-label">Foto Bukti Surat Permohonan</label>
                                    @if($laporan->foto_permohonan)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $laporan->foto_permohonan) }}" alt="Foto Permohonan" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('foto_permohonan') is-invalid @enderror" id="foto_permohonan" name="foto_permohonan" accept="image/*">
                                    @error('foto_permohonan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="foto_tiba" class="form-label">Foto Jenazah Tiba</label>
                                    @if($laporan->foto_tiba)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $laporan->foto_tiba) }}" alt="Foto Jenazah Tiba" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('foto_tiba') is-invalid @enderror" id="foto_tiba" name="foto_tiba" accept="image/*">
                                    @error('foto_tiba')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="foto_awal" class="form-label">Foto Awal Pembakaran</label>
                                    @if($laporan->foto_awal)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $laporan->foto_awal) }}" alt="Foto Awal" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('foto_awal') is-invalid @enderror" id="foto_awal" name="foto_awal" accept="image/*">
                                    @error('foto_awal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="foto_akhir" class="form-label">Foto Akhir Pembakaran</label>
                                    @if($laporan->foto_akhir)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $laporan->foto_akhir) }}" alt="Foto Akhir" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('foto_akhir') is-invalid @enderror" id="foto_akhir" name="foto_akhir" accept="image/*">
                                    @error('foto_akhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="foto_tulang" class="form-label">Foto Tulang</label>
                                    @if($laporan->foto_tulang)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $laporan->foto_tulang) }}" alt="Foto Tulang" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('foto_tulang') is-invalid @enderror" id="foto_tulang" name="foto_tulang" accept="image/*">
                                    @error('foto_tulang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="foto_abu" class="form-label">Foto Abu</label>
                                    @if($laporan->foto_abu)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $laporan->foto_abu) }}" alt="Foto Abu" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('foto_abu') is-invalid @enderror" id="foto_abu" name="foto_abu" accept="image/*">
                                    @error('foto_abu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('karyawan.laporan.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update Laporan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
