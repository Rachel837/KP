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
                        <form action="{{ route('karyawan.jadwal.update', $jadwal->id_jadwal) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <h5 class="mb-3 text-dark fw-bold">Data Jenazah & Penanggung Jawab</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_jenazah" class="form-label fw-medium text-dark">Nama Jenazah</label>
                                    <input type="text" class="form-control @error('nama_jenazah') is-invalid @enderror" id="nama_jenazah" name="nama_jenazah" value="{{ old('nama_jenazah', $jadwal->pelanggan->nama ?? $jadwal->nama_pelanggan) }}" required placeholder="Nama Jenazah">
                                    @error('nama_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="usia_jenazah" class="form-label fw-medium text-dark">Usia Jenazah (Tahun)</label>
                                    <input type="number" class="form-control @error('usia_jenazah') is-invalid @enderror" id="usia_jenazah" name="usia_jenazah" value="{{ old('usia_jenazah', $jadwal->pelanggan->usia ?? $jadwal->umur) }}" required placeholder="Contoh: 60">
                                    @error('usia_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir_jenazah" class="form-label fw-medium text-dark">Tempat Lahir Jenazah</label>
                                    <input type="text" class="form-control @error('tempat_lahir_jenazah') is-invalid @enderror" id="tempat_lahir_jenazah" name="tempat_lahir_jenazah" value="{{ old('tempat_lahir_jenazah', $jadwal->pelanggan->tempat_lahir ?? '') }}" required placeholder="Tempat Lahir Jenazah">
                                    @error('tempat_lahir_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir_jenazah" class="form-label fw-medium text-dark">Tanggal Lahir Jenazah</label>
                                    <input type="date" class="form-control @error('tanggal_lahir_jenazah') is-invalid @enderror" id="tanggal_lahir_jenazah" name="tanggal_lahir_jenazah" value="{{ old('tanggal_lahir_jenazah', $jadwal->pelanggan->tanggal_lahir ?? '') }}" required>
                                    @error('tanggal_lahir_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="alamat" class="form-label fw-medium text-dark">Alamat Jenazah</label>
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat', $jadwal->alamat) }}" placeholder="Alamat Jenazah">
                                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            @php
                                $fotoJenazah = $jadwal->picture ? $jadwal->picture->foto_jenazah : null;
                            @endphp

                            @if($fotoJenazah)
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-medium text-dark d-block">Foto Jenazah Saat Ini</label>
                                        <img src="{{ asset('storage/' . $fotoJenazah) }}" alt="Foto Jenazah" class="img-thumbnail mb-2" style="max-height: 180px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="foto_jenazah" class="form-label fw-medium text-dark">Foto Jenazah (Biarkan kosong jika tidak ingin mengubah)</label>
                                    <input type="file" class="form-control @error('foto_jenazah') is-invalid @enderror" id="foto_jenazah" name="foto_jenazah" accept="image/*">
                                    @error('foto_jenazah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_penanggung_jawab" class="form-label fw-medium text-dark">Nama Penanggung Jawab Jenazah</label>
                                    <input type="text" class="form-control @error('nama_penanggung_jawab') is-invalid @enderror" id="nama_penanggung_jawab" name="nama_penanggung_jawab" value="{{ old('nama_penanggung_jawab', $jadwal->pelanggan->penannggung_jawab ?? $jadwal->pelanggan->penanggung_jawab ?? '') }}" required placeholder="Nama Penanggung Jawab">
                                    @error('nama_penanggung_jawab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon_penanggung_jawab" class="form-label fw-medium text-dark">No. Telepon Penanggung Jawab</label>
                                    <input type="text" class="form-control @error('no_telepon_penanggung_jawab') is-invalid @enderror" id="no_telepon_penanggung_jawab" name="no_telepon_penanggung_jawab" value="{{ old('no_telepon_penanggung_jawab', $jadwal->pelanggan->no_telepon ?? '') }}" required placeholder="Contoh: 08123456789">
                                    @error('no_telepon_penanggung_jawab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <hr class="my-4 text-muted">
                            <h5 class="mb-3 text-dark fw-bold">Detail Jadwal Kremasi</h5>

                             <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="date" class="form-label fw-medium text-dark">Tanggal Kremasi</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $jadwal->date) }}" required>
                                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="ruangan_id" class="form-label fw-medium text-dark">Ruangan/Mesin</label>
                                    <select class="form-select @error('ruangan_id') is-invalid @enderror" id="ruangan_id" name="ruangan_id" required>
                                        @foreach($ruangans as $ruang)
                                            <option value="{{ $ruang->id }}" {{ old('ruangan_id', $jadwal->ruangan_id) == $ruang->id ? 'selected' : '' }}>{{ $ruang->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('ruangan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="jam_awal" class="form-label fw-medium text-dark">Jam Mulai</label>
                                    <select class="form-select @error('jam_awal') is-invalid @enderror" id="jam_awal" name="jam_awal" data-selected-value="{{ old('jam_awal', ($jadwal->laporan && $jadwal->laporan->jam_awal) ? substr($jadwal->laporan->jam_awal, 0, 5) : '') }}" required>
                                        <option value="" disabled selected>Pilih Jam</option>
                                    </select>
                                    @error('jam_awal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="status" class="form-label fw-medium text-dark">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        @php
                                            $isSelesai = ($jadwal->picture && $jadwal->picture->foto_abu) || ($jadwal->laporan && $jadwal->laporan->lama_pembakaran);
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ruanganSelect = document.getElementById('ruangan_id');
    const jamAwalSelect = document.getElementById('jam_awal');
    const dateInput = document.getElementById('date');
    
    if (!ruanganSelect || !jamAwalSelect || !dateInput) return;
    
    // Define slots per machine (ruangan ID)
    const slots = {
        '1': ['09:30', '13:00', '15:30'],
        '2': ['10:30', '14:00', '16:00']
    };
    
    const initialValue = jamAwalSelect.getAttribute('data-selected-value') || '';

    function updateJamOptions() {
        const selectedRuangan = ruanganSelect.value;
        const selectedDate = dateInput.value;
        let allowedSlots = slots[selectedRuangan] || [];
        
        // Clear options first to show loading state if needed
        jamAwalSelect.innerHTML = '<option value="" disabled selected>Memuat jam...</option>';
        
        // Filter out past times if the selected date is today
        if (selectedDate && allowedSlots.length > 0) {
            const today = new Date();
            const selected = new Date(selectedDate);
            
            // Check if selected date is today
            if (today.getFullYear() === selected.getFullYear() &&
                today.getMonth() === selected.getMonth() &&
                today.getDate() === selected.getDate()) {
                
                const currentHour = today.getHours();
                const currentMinute = today.getMinutes();
                
                allowedSlots = allowedSlots.filter(slot => {
                    // Always allow the initially selected time so the user can save without changing it
                    // if it happens to be in the past now.
                    if (slot === initialValue || slot + ':00' === initialValue || initialValue.startsWith(slot)) {
                        return true;
                    }
                    
                    const [slotHour, slotMinute] = slot.split(':').map(Number);
                    if (slotHour > currentHour) return true;
                    if (slotHour === currentHour && slotMinute > currentMinute) return true;
                    return false;
                });
            }
        }
        
        // Fetch booked slots from backend
        if (selectedDate && selectedRuangan) {
            fetch(`/karyawan/jadwal/booked-slots?date=${selectedDate}&ruangan_id=${selectedRuangan}`)
                .then(response => response.json())
                .then(bookedSlots => {
                    // Filter out already booked slots
                    allowedSlots = allowedSlots.filter(slot => {
                        // if editing, allow current value even if it's considered "booked" by the query
                        if (slot === initialValue || slot + ':00' === initialValue || initialValue.startsWith(slot)) {
                            return true;
                        }
                        return !bookedSlots.includes(slot) && !bookedSlots.includes(slot + ':00');
                    });
                    renderOptions(allowedSlots, selectedRuangan);
                })
                .catch(error => {
                    console.error('Error fetching booked slots:', error);
                    renderOptions(allowedSlots, selectedRuangan);
                });
        } else {
            renderOptions(allowedSlots, selectedRuangan);
        }
    }

    function renderOptions(allowedSlots, selectedRuangan) {
        jamAwalSelect.innerHTML = '<option value="" disabled selected>Pilih Jam</option>';
        
        if (allowedSlots.length === 0 && selectedRuangan) {
            const option = document.createElement('option');
            option.value = "";
            option.textContent = "Tidak ada jam tersedia";
            option.disabled = true;
            jamAwalSelect.appendChild(option);
        } else {
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
    }

    ruanganSelect.addEventListener('change', updateJamOptions);
    dateInput.addEventListener('change', updateJamOptions);
    
    // Initial load
    if (ruanganSelect.value || dateInput.value) {
        updateJamOptions();
    }
});
</script>
@endsection
