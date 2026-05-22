<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div class="content py-10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="mb-4">
                    <h1 class="fs-3 mb-1">Edit Jadwal Kremasi</h1>
                    <p class="text-muted">Ubah detail informasi jadwal kremasi.</p>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('karyawan.jadwal.update', $jadwal->idreports) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="nama_pelanggan" class="form-label fw-medium text-dark">Nama Almarhum</label>
                                    <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan', $jadwal->nama_pelanggan) }}" required placeholder="Nama Almarhum">
                                    @error('nama_pelanggan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="umur" class="form-label fw-medium text-dark">Umur</label>
                                    <input type="text" class="form-control @error('umur') is-invalid @enderror" id="umur" name="umur" value="{{ old('umur', $jadwal->umur) }}" placeholder="Contoh: 60">
                                    @error('umur')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="alamat" class="form-label fw-medium text-dark">Alamat</label>
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat', $jadwal->alamat) }}" placeholder="Alamat Almarhum">
                                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="date" class="form-label fw-medium text-dark">Tanggal Kremasi</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $jadwal->date) }}" required>
                                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="jam_awal" class="form-label fw-medium text-dark">Jam Awal</label>
                                    <input type="time" class="form-control @error('jam_awal') is-invalid @enderror" id="jam_awal" name="jam_awal" value="{{ old('jam_awal', $jadwal->jam_awal) }}" required>
                                    @error('jam_awal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="ruangan_id" class="form-label fw-medium text-dark">Ruangan/Mesin</label>
                                    <select class="form-select @error('ruangan_id') is-invalid @enderror" id="ruangan_id" name="ruangan_id" required>
                                        @foreach($ruangans as $ruang)
                                            <option value="{{ $ruang->id }}" {{ old('ruangan_id', $jadwal->ruangan_id) == $ruang->id ? 'selected' : '' }}>{{ $ruang->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('ruangan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="status" class="form-label fw-medium text-dark">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        @php
                                            $isSelesai = $jadwal->foto_abu || $jadwal->lama_pembakaran;
                                        @endphp
                                        <option value="Terjadwal" {{ !$isSelesai ? 'selected' : '' }}>Terjadwal</option>
                                        <option value="Selesai" {{ $isSelesai ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('karyawan.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update Jadwal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
