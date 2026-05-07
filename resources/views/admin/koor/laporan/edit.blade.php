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
                        <form action="{{ route('laporan.update', $laporan->idreports) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date" class="form-label">Tanggal Pelaksanaan Kremasi</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $laporan->date) }}" required>
                                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="waktu_tiba" class="form-label">Waktu Tiba</label>
                                    <input type="time" class="form-control @error('waktu_tiba') is-invalid @enderror" id="waktu_tiba" name="waktu_tiba" value="{{ old('waktu_tiba', $laporan->waktu_tiba) }}" required>
                                    @error('waktu_tiba')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jam_awal" class="form-label">Jam Mulai Kremasi</label>
                                    <input type="time" class="form-control @error('jam_awal') is-invalid @enderror" id="jam_awal" name="jam_awal" value="{{ old('jam_awal', $laporan->jam_awal) }}" required>
                                    @error('jam_awal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="jam_akhir" class="form-label">Jam Selesai Kremasi</label>
                                    <input type="time" class="form-control @error('jam_akhir') is-invalid @enderror" id="jam_akhir" name="jam_akhir" value="{{ old('jam_akhir', $laporan->jam_akhir) }}" required>
                                    @error('jam_akhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pelanggan_kremasi_id" class="form-label">Pelanggan</label>
                                    <select class="form-select @error('pelanggan_kremasi_id') is-invalid @enderror" id="pelanggan_kremasi_id" name="pelanggan_kremasi_id" required>
                                        @foreach($pelanggans as $pel)
                                            <option value="{{ $pel->id }}" {{ old('pelanggan_kremasi_id', $laporan->pelanggan_kremasi_id) == $pel->id ? 'selected' : '' }}>{{ $pel->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('pelanggan_kremasi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ruangan_id" class="form-label">Ruangan</label>
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
                                    <label for="jam_meninggal" class="form-label">Jam Meninggal</label>
                                    <input type="time" class="form-control @error('jam_meninggal') is-invalid @enderror" id="jam_meninggal" name="jam_meninggal" value="{{ old('jam_meninggal', $laporan->jam_meninggal) }}">
                                    @error('jam_meninggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_meninggal" class="form-label">Tanggal Meninggal</label>
                                    <input type="date" class="form-control @error('tanggal_meninggal') is-invalid @enderror" id="tanggal_meninggal" name="tanggal_meninggal" value="{{ old('tanggal_meninggal', $laporan->tanggal_meninggal) }}">
                                    @error('tanggal_meninggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jumlah_solar" class="form-label">Jumlah Solar (Liter)</label>
                                    <input type="number" step="0.01" class="form-control @error('jumlah_solar') is-invalid @enderror" id="jumlah_solar" name="jumlah_solar" value="{{ old('jumlah_solar', $laporan->jumlah_solar) }}">
                                    @error('jumlah_solar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="pemakaian_listrik" class="form-label">Pemakaian Listrik (kWh)</label>
                                    <input type="number" step="0.01" class="form-control @error('pemakaian_listrik') is-invalid @enderror" id="pemakaian_listrik" name="pemakaian_listrik" value="{{ old('pemakaian_listrik', $laporan->pemakaian_listrik) }}">
                                    @error('pemakaian_listrik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
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
