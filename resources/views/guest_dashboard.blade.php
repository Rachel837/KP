<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krema Track - Jadwal Kremasi</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <style>
        :root {
            --primary: #2b4c6f;
            --primary-hover: #1e3550;
            --accent: #d97706; /* Warm amber */
            --accent-light: #fef3c7;
            --bg-gradient-start: #f8fafc;
            --bg-gradient-end: #f1f5f9;
            --card-border: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* Glassmorphism Header */
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.35rem;
            color: var(--primary);
            letter-spacing: -0.5px;
            transition: transform 0.2s ease;
        }

        .brand-logo:hover {
            transform: scale(1.02);
            color: var(--primary);
        }

        .brand-logo i {
            font-size: 1.6rem;
            color: var(--accent);
        }

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.3);
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(217, 119, 6, 0.15) 0%, rgba(217, 119, 6, 0) 70%);
            pointer-events: none;
        }

        .hero-date {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(4px);
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Search & Filter Card */
        .filter-card {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            padding: 24px;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .form-control-custom {
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(43, 76, 111, 0.15);
            outline: none;
        }

        /* Schedule Cards */
        .schedule-card {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            padding: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .schedule-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -8px rgba(15, 23, 42, 0.08);
            border-color: #cbd5e1;
        }

        .schedule-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 6px;
        }

        .schedule-card.status-terjadwal::before {
            background-color: var(--accent);
        }

        .schedule-card.status-selesai::before {
            background-color: #10b981; /* Emerald green */
        }

        .time-badge {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .alm-name {
            font-size: 1.35rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .info-pill {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-status {
            padding: 8px 16px;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 50px;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        .badge-status-terjadwal {
            background-color: var(--accent-light);
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge-status-selesai {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        /* Quick Stat Badge */
        .stat-badge {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 10px 20px;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
        }

        /* Empty State */
        .empty-state {
            background: white;
            border-radius: 24px;
            border: 1px dashed #cbd5e1;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
        }

        .empty-state i {
            font-size: 4rem;
            color: #94a3b8;
            margin-bottom: 20px;
            display: inline-block;
        }

        /* Custom buttons */
        .btn-primary-custom {
            background-color: var(--primary);
            color: white !important;
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 24px;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(43, 76, 111, 0.25);
        }

        .btn-outline-custom {
            background-color: transparent;
            color: var(--primary) !important;
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 24px;
            border: 2px solid var(--primary);
            transition: all 0.2s ease;
        }

        .btn-outline-custom:hover {
            background-color: rgba(43, 76, 111, 0.05);
            transform: translateY(-1px);
        }

        /* Footer */
        footer {
            background-color: #0f172a;
            color: #94a3b8;
            padding: 40px 0;
            margin-top: 60px;
            border-top: 1px solid #1e293b;
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <header class="glass-header py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ url('/') }}" class="brand-logo">
                <i class="ti ti-flame"></i>
                <span>Krema Track</span>
            </a>
            
            <div class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary-custom d-flex align-items-center gap-2">
                        <i class="ti ti-dashboard"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-custom">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary-custom">
                            Daftar
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        
        <!-- Hero Section -->
        <div class="hero-banner">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="hero-date mb-3">
                        <i class="ti ti-calendar-event"></i>
                        <span>{{ \Carbon\Carbon::parse($selectedDate)->locale('id')->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <h1 class="display-5 fw-bold mb-2">Jadwal Layanan Kremasi</h1>
                    <p class="lead mb-0 text-white-50">Menyajikan jadwal pelaksanaan kremasi jenazah secara transparan dan real-time.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-flex gap-3">
                        <div class="stat-badge">
                            <span class="fs-4 fw-bold text-warning">{{ $jadwals->filter(fn($j) => !($j->foto_abu || $j->lama_pembakaran))->count() }}</span>
                            <span class="small text-white-50">Terjadwal</span>
                        </div>
                        <div class="stat-badge">
                            <span class="fs-4 fw-bold text-success">{{ $jadwals->filter(fn($j) => $j->foto_abu || $j->lama_pembakaran)->count() }}</span>
                            <span class="small text-white-50">Selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Filter Bar -->
            <div class="col-12">
                <div class="filter-card">
                    <form action="{{ url('/') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label fw-semibold text-secondary small">Nama Almarhum</label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y ps-3 text-muted">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" name="search" value="{{ $searchQuery }}" class="form-control form-control-custom ps-5" placeholder="Cari nama almarhum...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-secondary small">Tanggal Kremasi</label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y ps-3 text-muted">
                                    <i class="ti ti-calendar"></i>
                                </span>
                                <input type="date" name="date" value="{{ $selectedDate }}" onchange="this.form.submit()" class="form-control form-control-custom ps-5">
                            </div>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary-custom flex-grow-1">
                                <i class="ti ti-filter me-1"></i> Saring
                            </button>
                            @if($searchQuery || $selectedDate !== $today)
                                <a href="{{ url('/') }}" class="btn btn-outline-custom px-3">
                                    <i class="ti ti-refresh"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- List Schedule -->
            <div class="col-12">
                <h3 class="fw-bold mb-4 d-flex align-items-center gap-2 text-dark">
                    <i class="ti ti-list-details text-primary"></i>
                    @if($selectedDate === $today)
                        Jadwal Kremasi Hari Ini
                    @else
                        Jadwal Kremasi Tanggal {{ \Carbon\Carbon::parse($selectedDate)->locale('id')->translatedFormat('d F Y') }}
                    @endif
                </h3>

                <div class="d-flex flex-column gap-3">
                    @forelse($jadwals as $jadwal)
                        @php
                            $isSelesai = $jadwal->foto_abu || $jadwal->lama_pembakaran;
                            $statusClass = $isSelesai ? 'status-selesai' : 'status-terjadwal';
                        @endphp
                        
                        <div class="schedule-card {{ $statusClass }}">
                            <div class="row align-items-center">
                                <!-- Time info -->
                                <div class="col-md-3 col-lg-2 mb-3 mb-md-0">
                                    <div class="time-badge">
                                        <i class="ti ti-clock"></i>
                                        <span>{{ \Carbon\Carbon::parse($jadwal->jam_awal)->format('H:i') }}</span>
                                    </div>
                                    <span class="small text-muted block mt-1 d-block">Waktu Pelaksanaan</span>
                                </div>
                                
                                <!-- Name and Details -->
                                <div class="col-md-5 col-lg-6 mb-3 mb-md-0">
                                    <div class="alm-name">{{ $jadwal->nama_pelanggan }}</div>
                                    <div class="d-flex flex-wrap gap-2">
                                        @if($jadwal->umur)
                                            <span class="info-pill">
                                                <i class="ti ti-hourglass-empty"></i>
                                                {{ $jadwal->umur }} Tahun
                                            </span>
                                        @endif
                                        @if($jadwal->alamat)
                                            <span class="info-pill">
                                                <i class="ti ti-map-pin"></i>
                                                {{ $jadwal->alamat }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Room/Machine -->
                                <div class="col-md-2 col-lg-2 mb-3 mb-md-0">
                                    <span class="info-pill border-primary text-primary" style="background-color: rgba(43, 76, 111, 0.05);">
                                        <i class="ti ti-box"></i>
                                        Mesin {{ $jadwal->ruangan->nama ?? '-' }}
                                    </span>
                                    <span class="small text-muted d-block mt-1">Ruang Pembakaran</span>
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="col-md-2 col-lg-2 text-md-end">
                                    @if($isSelesai)
                                        <span class="badge-status badge-status-selesai">
                                            <i class="ti ti-check me-1"></i> Selesai
                                        </span>
                                    @else
                                        <span class="badge-status badge-status-terjadwal">
                                            <i class="ti ti-hourglass-low me-1"></i> Terjadwal
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="ti ti-calendar-off"></i>
                            <h4 class="fw-bold text-dark mb-2">Tidak Ada Jadwal Kremasi</h4>
                            <p class="text-secondary mb-0">Belum ada agenda kremasi yang terdaftar untuk tanggal ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-2 fw-semibold text-white">&copy; {{ date('Y') }} Krema Track. Semua Hak Dilindungi.</p>
            <p class="small text-white-50 mb-0">Sistem Informasi Monitoring dan Penjadwalan Pelayanan Kremasi Jenazah.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
