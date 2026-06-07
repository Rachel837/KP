<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div class="content py-10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="mb-4">
                    <h1 class="fs-3 mb-1">Tambah Jadwal Kremasi</h1>
                    <p class="text-muted">Silakan isi informasi di bawah ini untuk menjadwalkan kremasi baru.</p>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('karyawan.jadwal.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <h5 class="mb-3 text-dark fw-bold">Data Jenazah & Penanggung Jawab</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_jenazah" class="form-label fw-medium text-dark">Nama Jenazah (Almarhum)</label>
                                    <input type="text" class="form-control @error('nama_jenazah') is-invalid @enderror" id="nama_jenazah" name="nama_jenazah" value="{{ old('nama_jenazah') }}" required placeholder="Nama Jenazah">
                                    @error('nama_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="usia_jenazah" class="form-label fw-medium text-dark">Usia Jenazah (Tahun)</label>
                                    <input type="number" class="form-control @error('usia_jenazah') is-invalid @enderror" id="usia_jenazah" name="usia_jenazah" value="{{ old('usia_jenazah') }}" required placeholder="Contoh: 60">
                                    @error('usia_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir_jenazah" class="form-label fw-medium text-dark">Tempat Lahir Jenazah</label>
                                    <input type="text" class="form-control @error('tempat_lahir_jenazah') is-invalid @enderror" id="tempat_lahir_jenazah" name="tempat_lahir_jenazah" value="{{ old('tempat_lahir_jenazah') }}" required placeholder="Tempat Lahir Jenazah">
                                    @error('tempat_lahir_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir_jenazah" class="form-label fw-medium text-dark">Tanggal Lahir Jenazah</label>
                                    <input type="date" class="form-control @error('tanggal_lahir_jenazah') is-invalid @enderror" id="tanggal_lahir_jenazah" name="tanggal_lahir_jenazah" value="{{ old('tanggal_lahir_jenazah') }}" required>
                                    @error('tanggal_lahir_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_penanggung_jawab" class="form-label fw-medium text-dark">Nama Penanggung Jawab Jenazah</label>
                                    <input type="text" class="form-control @error('nama_penanggung_jawab') is-invalid @enderror" id="nama_penanggung_jawab" name="nama_penanggung_jawab" value="{{ old('nama_penanggung_jawab') }}" required placeholder="Nama Penanggung Jawab">
                                    @error('nama_penanggung_jawab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon_penanggung_jawab" class="form-label fw-medium text-dark">No. Telepon Penanggung Jawab</label>
                                    <input type="text" class="form-control @error('no_telepon_penanggung_jawab') is-invalid @enderror" id="no_telepon_penanggung_jawab" name="no_telepon_penanggung_jawab" value="{{ old('no_telepon_penanggung_jawab') }}" required placeholder="Contoh: 08123456789">
                                    @error('no_telepon_penanggung_jawab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <hr class="my-4 text-muted">
                            <h5 class="mb-3 text-dark fw-bold">Detail Jadwal Kremasi</h5>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="alamat" class="form-label fw-medium text-dark">Alamat Almarhum</label>
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}" placeholder="Alamat Almarhum">
                                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="date" class="form-label fw-medium text-dark">Tanggal Kremasi</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" required>
                                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="jam_awal" class="form-label fw-medium text-dark">Jam Mulai</label>
                                    <input type="time" class="form-control @error('jam_awal') is-invalid @enderror" id="jam_awal" name="jam_awal" value="{{ old('jam_awal') }}" required>
                                    @error('jam_awal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="ruangan_id" class="form-label fw-medium text-dark">Ruangan/Mesin</label>
                                    <select class="form-select @error('ruangan_id') is-invalid @enderror" id="ruangan_id" name="ruangan_id" required>
                                        <option value="" selected disabled>Pilih Ruangan/Mesin</option>
                                        @foreach($ruangans as $ruang)
                                            <option value="{{ $ruang->id }}" {{ old('ruangan_id') == $ruang->id ? 'selected' : '' }}>{{ $ruang->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('ruangan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('karyawan.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
