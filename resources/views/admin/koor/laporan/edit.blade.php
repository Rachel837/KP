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
                        <form action="{{ route('laporan.update', $laporan->idreports) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="nama_pelanggan" class="form-label">Nama Almarhum</label>
                                    <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan', $laporan->nama_pelanggan) }}" required placeholder="Nama Almarhum">
                                    @error('nama_pelanggan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat', $laporan->alamat) }}" placeholder="Alamat Almarhum">
                                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="umur" class="form-label">Umur</label>
                                    <input type="text" class="form-control @error('umur') is-invalid @enderror" id="umur" name="umur" value="{{ old('umur', $laporan->umur) }}" placeholder="Contoh: 60">
                                    @error('umur')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="ruangan_id" class="form-label">Ruangan</label>
                                    <select class="form-select @error('ruangan_id') is-invalid @enderror" id="ruangan_id" name="ruangan_id" required>
                                        @foreach($ruangans as $ruang)
                                            <option value="{{ $ruang->id }}" {{ old('ruangan_id', $laporan->ruangan_id) == $ruang->id ? 'selected' : '' }}>{{ $ruang->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('ruangan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <hr class="my-4">

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

                                <div class="col-md-6 mb-3">
                                    <label for="jumlah_solar" class="form-label">Pemakaian Solar (Liter)</label>
                                    <input type="number" step="0.01" class="form-control @error('jumlah_solar') is-invalid @enderror" id="jumlah_solar" name="jumlah_solar" value="{{ old('jumlah_solar', $laporan->jumlah_solar) }}">
                                    @error('jumlah_solar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="lama_pembakaran" class="form-label">Lama Waktu Pembakaran (Menit)</label>
                                    <input type="text" class="form-control @error('lama_pembakaran') is-invalid @enderror" id="lama_pembakaran" name="lama_pembakaran" value="{{ old('lama_pembakaran', $laporan->lama_pembakaran) }}" placeholder="Contoh: 150">
                                    @error('lama_pembakaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
