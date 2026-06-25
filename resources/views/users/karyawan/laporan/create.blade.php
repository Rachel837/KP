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
                        <h1 class="fs-3 mb-1">Buat Laporan Jadwal</h1>
                        <p class="text-muted">
                            @if($selectedJadwal)
                                Mengisi laporan untuk Jenazah <strong>{{ $selectedJadwal->nama_pelanggan }}</strong>.
                            @else
                                Mengisi laporan jadwal baru (Input Manual).
                            @endif
                        </p>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form action="{{ route('karyawan.laporan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <input type="hidden" name="jadwal_id" value="{{ $selectedJadwal ? $selectedJadwal->id_jadwal : '' }}">

                                <h5 class="mb-3 text-dark fw-bold">Data Jenazah & Penanggung Jawab</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_jenazah" class="form-label fw-medium text-dark">Nama Jenazah</label>
                                        <input type="text" class="form-control @error('nama_jenazah') is-invalid @enderror" id="nama_jenazah" name="nama_jenazah" value="{{ old('nama_jenazah', $selectedJadwal ? ($selectedJadwal->pelanggan->nama ?? $selectedJadwal->nama_pelanggan) : '') }}" required placeholder="Nama Jenazah" {{ $selectedJadwal ? 'readonly style=background-color:#e9ecef;' : '' }}>
                                        @error('nama_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="usia_jenazah" class="form-label fw-medium text-dark">Usia Jenazah (Tahun)</label>
                                        <input type="number" class="form-control @error('usia_jenazah') is-invalid @enderror" id="usia_jenazah" name="usia_jenazah" value="{{ old('usia_jenazah', $selectedJadwal ? ($selectedJadwal->pelanggan->usia ?? $selectedJadwal->umur) : '') }}" required placeholder="Contoh: 60" {{ $selectedJadwal ? 'readonly style=background-color:#e9ecef;' : '' }}>
                                        @error('usia_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tempat_lahir_jenazah" class="form-label fw-medium text-dark">Tempat Lahir Jenazah</label>
                                        <input type="text" class="form-control @error('tempat_lahir_jenazah') is-invalid @enderror" id="tempat_lahir_jenazah" name="tempat_lahir_jenazah" value="{{ old('tempat_lahir_jenazah', ($selectedJadwal && $selectedJadwal->pelanggan) ? $selectedJadwal->pelanggan->tempat_lahir : '') }}" required placeholder="Tempat Lahir Jenazah" {{ $selectedJadwal ? 'readonly style=background-color:#e9ecef;' : '' }}>
                                        @error('tempat_lahir_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_lahir_jenazah" class="form-label fw-medium text-dark">Tanggal Lahir Jenazah</label>
                                        <input type="date" class="form-control @error('tanggal_lahir_jenazah') is-invalid @enderror" id="tanggal_lahir_jenazah" name="tanggal_lahir_jenazah" value="{{ old('tanggal_lahir_jenazah', ($selectedJadwal && $selectedJadwal->pelanggan) ? $selectedJadwal->pelanggan->tanggal_lahir : '') }}" required {{ $selectedJadwal ? 'readonly style=pointer-events:none;background-color:#e9ecef;' : '' }}>
                                        @error('tanggal_lahir_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="alamat" class="form-label fw-medium text-dark">Alamat Jenazah</label>
                                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat', $selectedJadwal ? $selectedJadwal->alamat : '') }}" placeholder="Alamat Jenazah" {{ $selectedJadwal ? 'readonly style=background-color:#e9ecef;' : '' }}>
                                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_penanggung_jawab" class="form-label fw-medium text-dark">Nama Penanggung Jawab Jenazah</label>
                                        <input type="text" class="form-control @error('nama_penanggung_jawab') is-invalid @enderror" id="nama_penanggung_jawab" name="nama_penanggung_jawab" value="{{ old('nama_penanggung_jawab', ($selectedJadwal && $selectedJadwal->pelanggan) ? ($selectedJadwal->pelanggan->penannggung_jawab ?? $selectedJadwal->pelanggan->penanggung_jawab ?? '') : '') }}" required placeholder="Nama Penanggung Jawab" {{ $selectedJadwal ? 'readonly style=background-color:#e9ecef;' : '' }}>
                                        @error('nama_penanggung_jawab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="no_telepon_penanggung_jawab" class="form-label fw-medium text-dark">No. Telepon Penanggung Jawab</label>
                                        <input type="text" class="form-control @error('no_telepon_penanggung_jawab') is-invalid @enderror" id="no_telepon_penanggung_jawab" name="no_telepon_penanggung_jawab" value="{{ old('no_telepon_penanggung_jawab', ($selectedJadwal && $selectedJadwal->pelanggan) ? $selectedJadwal->pelanggan->no_telepon : '') }}" required placeholder="Contoh: 08123456789" {{ $selectedJadwal ? 'readonly style=background-color:#e9ecef;' : '' }}>
                                        @error('no_telepon_penanggung_jawab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <hr class="my-4 text-muted">
                                <h5 class="mb-3 text-dark fw-bold">Detail Pelaksanaan Laporan & Jadwal</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="date" class="form-label fw-medium text-dark">Tanggal Pelaksanaan Kremasi</label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $selectedJadwal ? $selectedJadwal->date : '') }}" required {{ $selectedJadwal ? 'readonly style=pointer-events:none;background-color:#e9ecef;' : '' }}>
                                        @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="ruangan_id" class="form-label fw-medium text-dark">Ruangan/Mesin</label>
                                        <select class="form-select @error('ruangan_id') is-invalid @enderror" id="ruangan_id" name="ruangan_id" required {{ $selectedJadwal ? 'readonly style=pointer-events:none;background-color:#e9ecef;tabindex=-1' : '' }}>
                                            <option value="" disabled {{ !$selectedJadwal ? 'selected' : '' }}>Pilih Ruangan/Mesin</option>
                                            @foreach($ruangans as $ruang)
                                                <option value="{{ $ruang->id }}" {{ old('ruangan_id', $selectedJadwal ? $selectedJadwal->ruangan_id : '') == $ruang->id ? 'selected' : '' }}>{{ $ruang->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('ruangan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="waktu_tiba" class="form-label fw-medium text-dark">Waktu Tiba</label>
                                        <input type="time" class="form-control @error('waktu_tiba') is-invalid @enderror" id="waktu_tiba" name="waktu_tiba" value="{{ old('waktu_tiba', $selectedJadwal ? (($selectedJadwal->laporan && $selectedJadwal->laporan->waktu_tiba) ? substr($selectedJadwal->laporan->waktu_tiba, 0, 5) : '') : '') }}" required>
                                        @error('waktu_tiba')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="jam_awal" class="form-label fw-medium text-dark">Jam Mulai Kremasi</label>
                                        <select class="form-select @error('jam_awal') is-invalid @enderror" id="jam_awal" name="jam_awal" data-selected-value="{{ old('jam_awal', $selectedJadwal ? (($selectedJadwal->laporan && $selectedJadwal->laporan->jam_awal) ? substr($selectedJadwal->laporan->jam_awal, 0, 5) : '') : '') }}" required {{ $selectedJadwal ? 'readonly style=pointer-events:none;background-color:#e9ecef;tabindex=-1' : '' }}>
                                            <option value="" disabled selected>Pilih Jam</option>
                                        </select>
                                        @error('jam_awal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="jam_akhir" class="form-label fw-medium text-dark">Jam Selesai Kremasi</label>
                                        <input type="time" class="form-control @error('jam_akhir') is-invalid @enderror" id="jam_akhir" name="jam_akhir" value="{{ old('jam_akhir', $selectedJadwal ? (($selectedJadwal->laporan && $selectedJadwal->laporan->jam_akhir) ? substr($selectedJadwal->laporan->jam_akhir, 0, 5) : '') : '') }}" required>
                                        @error('jam_akhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="jumlah_solar" class="form-label fw-medium text-dark">Pemakaian Solar (Liter)</label>
                                        <input type="number" step="0.01" class="form-control @error('jumlah_solar') is-invalid @enderror" id="jumlah_solar" name="jumlah_solar" value="{{ old('jumlah_solar', $selectedJadwal ? ($selectedJadwal->laporan ? $selectedJadwal->laporan->jumlah_solar : '') : '') }}" required placeholder="Contoh: 50.5">
                                        @error('jumlah_solar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <hr class="my-4 text-muted">
                                <h5 class="mb-3 text-dark">Dokumentasi Foto</h5>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_permohonan" class="form-label fw-medium text-dark">Foto Bukti Surat Permohonan</label>
                                        <input type="file" class="form-control @error('foto_permohonan') is-invalid @enderror" id="foto_permohonan" name="foto_permohonan" accept="image/*" required>
                                        @error('foto_permohonan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_tiba" class="form-label fw-medium text-dark">Foto Jenazah Tiba</label>
                                        <input type="file" class="form-control @error('foto_tiba') is-invalid @enderror" id="foto_tiba" name="foto_tiba" accept="image/*" required>
                                        @error('foto_tiba')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_awal" class="form-label fw-medium text-dark">Foto Awal Pembakaran</label>
                                        <input type="file" class="form-control @error('foto_awal') is-invalid @enderror" id="foto_awal" name="foto_awal" accept="image/*" required>
                                        @error('foto_awal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_akhir" class="form-label fw-medium text-dark">Foto Akhir Pembakaran</label>
                                        <input type="file" class="form-control @error('foto_akhir') is-invalid @enderror" id="foto_akhir" name="foto_akhir" accept="image/*" required>
                                        @error('foto_akhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_tulang" class="form-label fw-medium text-dark">Foto Tulang</label>
                                        <input type="file" class="form-control @error('foto_tulang') is-invalid @enderror" id="foto_tulang" name="foto_tulang" accept="image/*" required>
                                        @error('foto_tulang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="foto_abu" class="form-label fw-medium text-dark">Foto Abu</label>
                                        <input type="file" class="form-control @error('foto_abu') is-invalid @enderror" id="foto_abu" name="foto_abu" accept="image/*" required>
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
                    <!-- DAFTAR NAMA NAMA Jenazah -->
                    <div class="mb-4">
                        <h1 class="fs-3 mb-1">Tambah Laporan Jadwal</h1>
                        <p class="text-muted">Silakan pilih nama Jenazah dari jadwal kremasi yang sudah selesai di bawah ini untuk membuat laporan.</p>
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
                                    <p class="text-muted mb-0">Tidak ada jadwal kremasi dengan status Selesai yang belum dilaporkan.</p>
                                    <p class="text-muted small">Semua jadwal telah dilaporkan atau belum ada jadwal yang diselesaikan.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Jenazah</th>
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
                                                        <a href="{{ route('karyawan.laporan.create', ['jadwal_id' => $j->id_jadwal]) }}" class="fw-semibold text-primary text-decoration-none fs-5">
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
                                                    <td>{{ ($j->laporan && $j->laporan->jam_awal) ? substr($j->laporan->jam_awal, 0, 5) : '' }} WIB</td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border px-2.5 py-1">
                                                            {{ $j->ruangan->nama ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('karyawan.laporan.create', ['jadwal_id' => $j->id_jadwal]) }}" class="btn btn-sm btn-info text-white px-3">
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ruanganSelect = document.getElementById('ruangan_id');
    const jamAwalSelect = document.getElementById('jam_awal');
    
    if (!ruanganSelect || !jamAwalSelect) return;
    
    // Define slots per machine (ruangan ID)
    const slots = {
        '1': ['09:30', '13:00', '15:30'],
        '2': ['10:30', '14:00', '16:00']
    };
    
    const initialValue = jamAwalSelect.getAttribute('data-selected-value') || '';

    function updateJamOptions() {
        const selectedRuangan = ruanganSelect.value;
        const allowedSlots = slots[selectedRuangan] || [];
        
        // Clear options
        jamAwalSelect.innerHTML = '<option value="" disabled selected>Pilih Jam</option>';
        
        allowedSlots.forEach(slot => {
            const option = document.createElement('option');
            option.value = slot;
            option.textContent = slot + ' WIB';
            
            // Match with or without seconds
            if (slot === initialValue || (slot + ':00' === initialValue) || (initialValue.startsWith(slot))) {
                option.selected = true;
            }
            jamAwalSelect.appendChild(option);
        });
    }

    ruanganSelect.addEventListener('change', updateJamOptions);
    
    // Initial load
    if (ruanganSelect.value) {
        updateJamOptions();
    }
});
</script>
@endsection
