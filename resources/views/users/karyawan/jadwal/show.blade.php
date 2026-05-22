<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kremasi - {{ $jadwal->nama_pelanggan }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 0; }
            .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
            .card { border: none !important; box-shadow: none !important; }
        }
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        .report-header { border-bottom: 2px solid #000; padding-bottom: 20px; margin-bottom: 30px; text-align: center; }
        .report-title { text-transform: uppercase; font-weight: bold; font-size: 24px; margin-bottom: 5px; }
        .info-label { font-weight: 600; width: 200px; }
        .photo-box { border: 1px solid #dee2e6; padding: 10px; text-align: center; height: 100%; }
        .photo-box img { max-width: 100%; max-height: 200px; object-fit: contain; }
        .photo-label { font-size: 12px; margin-top: 5px; color: #6c757d; font-weight: bold; }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <div class="no-print mb-4 d-flex justify-content-between">
            <a href="{{ route('karyawan.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-primary">Cetak (Print)</button>
                <button onclick="downloadPDF()" class="btn btn-success">Download PDF</button>
            </div>
        </div>

        <div id="report-content" class="card shadow-sm border-0">
            <div class="card-body p-5">
                <div class="report-header">
                    <h1 class="report-title">Detail Jadwal & Kegiatan Kremasi</h1>
                    <p class="mb-0 text-muted">Aplikasi Manajemen Kremasi - KP</p>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3">Informasi Almarhum</h5>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="info-label">Nama Almarhum</td>
                                <td>: {{ $jadwal->nama_pelanggan }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Alamat</td>
                                <td>: {{ $jadwal->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Umur</td>
                                <td>: {{ $jadwal->umur ?? '-' }} Tahun</td>
                            </tr>
                            <tr>
                                <td class="info-label">Ruangan/Mesin</td>
                                <td>: {{ $jadwal->ruangan->nama ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3">Detail Pelaksanaan</h5>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="info-label">Tanggal Kremasi</td>
                                <td>: {{ \Carbon\Carbon::parse($jadwal->date)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Waktu Tiba</td>
                                <td>: {{ $jadwal->waktu_tiba ?? '-' }} WIB</td>
                            </tr>
                            <tr>
                                <td class="info-label">Waktu Pembakaran</td>
                                <td>: {{ $jadwal->jam_awal }} - {{ $jadwal->jam_akhir }} WIB</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3">Penggunaan Sumber Daya</h5>
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Pemakaian Solar</th>
                                    <th>Lama Pembakaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fs-4 fw-bold">{{ $jadwal->jumlah_solar ?? '0' }} L</td>
                                    <td class="fs-4 fw-bold">{{ $jadwal->lama_pembakaran ?? '-' }} Menit</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 text-end">
                        <div style="margin-top: 50px;">
                            <p class="mb-5">Dicetak pada: {{ date('d/m/Y H:i') }}</p>
                            <div style="width: 200px; border-bottom: 1px solid #000; margin-left: auto;"></div>
                            <p class="mt-2 pe-5">Petugas: {{ auth()->user()->name }}</p>
                        </div>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mb-4">Dokumentasi Kegiatan</h5>
                <div class="row g-3">
                    @php
                        $photos = [
                            ['label' => 'Bukti Permohonan', 'field' => 'foto_permohonan'],
                            ['label' => 'Jenazah Tiba', 'field' => 'foto_tiba'],
                            ['label' => 'Awal Pembakaran', 'field' => 'foto_awal'],
                            ['label' => 'Akhir Pembakaran', 'field' => 'foto_akhir'],
                            ['label' => 'Foto Tulang', 'field' => 'foto_tulang'],
                            ['label' => 'Foto Abu', 'field' => 'foto_abu']
                        ];
                    @endphp

                    @foreach($photos as $photo)
                        <div class="col-md-4">
                            <div class="photo-box">
                                @if($jadwal->{$photo['field']})
                                    <img src="{{ asset('storage/' . $jadwal->{$photo['field']}) }}" alt="{{ $photo['label'] }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="height: 200px;">
                                        Tidak ada foto
                                    </div>
                                @endif
                                <div class="photo-label">{{ $photo['label'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadPDF() {
            const element = document.getElementById('report-content');
            const opt = {
                margin:       10,
                filename:     'Jadwal_Kremasi_{{ $jadwal->nama_pelanggan }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                if (window.location.search.includes('download=1')) {
                    setTimeout(() => window.close(), 1000);
                }
            });
        }

        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('download') === '1') {
                downloadPDF();
            } else if (urlParams.get('print') === '1') {
                window.print();
            }
        };
    </script>
</body>
</html>
