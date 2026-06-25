<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kremasi - {{ $jadwal->nama_pelanggan }}</title>
    <link class="no-print" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 0; background-color: #fff; }
            .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
            #report-content { 
                border: none !important; 
                box-shadow: none !important; 
                padding: 15mm 20mm !important; 
                width: 210mm !important; 
                height: 295mm !important; 
                margin: 0 !important; 
                overflow: hidden !important;
            }
        }
        body { background-color: #f8f9fa; font-family: 'Inter', Arial, sans-serif; }
        #report-content {
            width: 210mm;
            height: 295mm;
            margin: 0 auto;
            padding: 15mm 20mm;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            box-sizing: border-box;
            overflow: hidden;
        }
        .report-title-section { text-align: center; margin-bottom: 15px; }
        .report-title { font-size: 22px; font-weight: 800; letter-spacing: 0.5px; color: #1a1a1a; margin-bottom: 2px; text-transform: uppercase; }
        .report-subtitle { font-size: 12px; color: #777777; font-weight: 500; }
        .info-table { border-collapse: collapse; width: 100%; margin-bottom: 0; }
        .info-table th { background-color: #fff !important; border: 1px solid #dee2e6; font-size: 13px; font-weight: 700; color: #1a1a1a; padding: 6px 12px; }
        .info-table td { border: 1px solid #dee2e6; font-size: 12px; padding: 5px 12px; }
        .info-label { font-weight: 700; color: #333; width: 38%; }
        .resource-card { background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0; padding: 10px; }
        .resource-label { font-size: 10px; font-weight: 700; color: #555; letter-spacing: 0.5px; }
        .resource-value { font-size: 32px; font-weight: 800; color: #1a1a1a; line-height: 1.1; }
        .resource-unit { font-size: 11px; color: #777; font-weight: 500; }
        .photo-card { border: 1px solid #dee2e6; background-color: #fff; padding: 4px; }
        .photo-wrapper { width: 100%; height: 210px; background-color: #f8f9fa; border: 1px solid #dee2e6; margin-bottom: 4px; }
        .photo-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        .photo-card-label { border: 1px solid #dee2e6; background-color: #fff; font-size: 11px; font-weight: 700; color: #333; }
        .report-footer { font-size: 10px; color: #888; border-top: 1px solid #dee2e6; }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>
    <div class="container my-4">
        <div class="no-print mb-3 d-flex justify-content-between">
            <a href="{{ route('karyawan.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
            <div class="d-flex gap-2">
                <button onclick="downloadPDF()" class="btn btn-success">Download PDF</button>
            </div>
        </div>

        <div id="report-content">
            <!-- Title Section -->
            <div class="report-title-section">
                <h1 class="report-title">Detail Jadwal & Kegiatan Kremasi</h1>
                <p class="report-subtitle mb-0">Aplikasi Manajemen Kremasi - KP</p>
            </div>

            <!-- Side-by-Side Tables -->
            <div class="row g-3 mb-3">
                <!-- Left Table: Informasi Jenazah -->
                <div class="col-6">
                    <table class="table info-table">
                        <thead>
                            <tr>
                                <th colspan="3" class="py-2 px-3">Informasi Jenazah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="info-label py-1 px-3">Nama Jenazah</td>
                                <td class="py-1 px-1 text-center" style="width: 5%;">:</td>
                                <td class="py-1 px-3">{{ $jadwal->nama_pelanggan }}</td>
                            </tr>
                            <tr>
                                <td class="info-label py-1 px-3">Alamat</td>
                                <td class="py-1 px-1 text-center">:</td>
                                <td class="py-1 px-3">{{ $jadwal->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="info-label py-1 px-3">Umur</td>
                                <td class="py-1 px-1 text-center">:</td>
                                <td class="py-1 px-3">{{ $jadwal->umur ?? '-' }} Tahun</td>
                            </tr>
                            <tr>
                                <td class="info-label py-1 px-3">Ruangan / Mesin</td>
                                <td class="py-1 px-1 text-center">:</td>
                                <td class="py-1 px-3">{{ $jadwal->ruangan->nama ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Right Table: Detail Pelaksanaan -->
                <div class="col-6">
                    <table class="table info-table">
                        <thead>
                            <tr>
                                <th colspan="3" class="py-2 px-3">Detail Pelaksanaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="info-label py-1 px-3">Tanggal Kremasi</td>
                                <td class="py-1 px-1 text-center" style="width: 5%;">:</td>
                                <td class="py-1 px-3">{{ \Carbon\Carbon::parse($jadwal->date)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td class="info-label py-1 px-3">Waktu Tiba</td>
                                <td class="py-1 px-1 text-center">:</td>
                                <td class="py-1 px-3">{{ $jadwal->laporan->waktu_tiba ?? '-' }} WIB</td>
                            </tr>
                            <tr>
                                <td class="info-label py-1 px-3">Waktu Pembakaran</td>
                                <td class="py-1 px-1 text-center">:</td>
                                <td class="py-1 px-3">{{ $jadwal->laporan->jam_awal ?? '-' }} - {{ $jadwal->laporan->jam_akhir ?? '-' }} WIB</td>
                            </tr>
                            <tr>
                                <td class="info-label py-1 px-3">Lama Pembakaran</td>
                                <td class="py-1 px-1 text-center">:</td>
                                <td class="py-1 px-3">{{ $jadwal->laporan->lama_pembakaran ?? '-' }} Menit</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Resource Usage -->
            <div class="mb-2 d-flex justify-content-center gap-3">
                <div class="text-center border border-secondary-subtle py-0 px-2 bg-light shadow-sm" style="border-top: 2px solid #1a1a1a !important; min-width: 140px;">
                    <div class="fw-bold text-muted" style="font-size: 9px; padding-top: 4px;">PEMAKAIAN SOLAR</div>
                    <div class="fw-bold text-dark pb-1" style="font-size: 13px;">{{ $jadwal->laporan->jumlah_solar ?? '0' }} <span style="font-size:10px; font-weight:500;">Liter</span></div>
                </div>
                <div class="text-center border border-secondary-subtle py-0 px-2 bg-light shadow-sm" style="border-top: 2px solid #1a1a1a !important; min-width: 140px;">
                    <div class="fw-bold text-muted" style="font-size: 9px; padding-top: 4px;">PEMAKAIAN LISTRIK</div>
                    <div class="fw-bold text-dark pb-1" style="font-size: 13px;">{{ $jadwal->laporan->pemakaian_listrik ? number_format($jadwal->laporan->pemakaian_listrik, 2) : '0' }} <span style="font-size:10px; font-weight:500;">kWH</span></div>
                </div>
            </div>            <!-- Documentation Activity -->
            <div class="mb-3">
                <h5 class="fw-bold text-dark mb-2" style="font-size: 14px;">Dokumentasi Kegiatan</h5>
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
                        <div class="col-4">
                            <div class="photo-card d-flex flex-column align-items-center bg-white" style="height: 100%;">
                                <div class="photo-wrapper w-100 bg-light d-flex align-items-center justify-content-center overflow-hidden mb-1">
                                    @if($jadwal->picture && $jadwal->picture->{$photo['field']})
                                        <img src="{{ asset('storage/' . $jadwal->picture->{$photo['field']}) }}" alt="{{ $photo['label'] }}">
                                    @else
                                        <span class="text-muted small" style="font-size: 10px;">Tidak ada foto</span>
                                    @endif
                                </div>
                                <div class="photo-card-label py-1 px-3 text-center w-75" style="margin-top: auto; margin-bottom: 2px;">
                                    {{ $photo['label'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Footer -->
            <div class="report-footer text-center py-2 mt-2">
                Dokumen ini dicetak secara otomatis oleh Aplikasi Manajemen Kremasi · {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>

    <script>
        function downloadPDF() {
            const element = document.getElementById('report-content');
            const opt = {
                margin:       0,
                filename:     'Jadwal_Kremasi_{{ $jadwal->nama_pelanggan }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true, scrollY: 0 },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak:    { mode: 'avoid-all' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                if (window.location.search.includes('download=1')) {
                    setTimeout(() => window.close(), 1000);
                }
            });
        }
    </script>
</body>
</html>
