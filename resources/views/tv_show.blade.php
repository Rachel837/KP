<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div class="content py-6">
    <div class="container-fluid">
        <!-- Immersive Dark Theme TV Show Slideshow Wrapper -->
        <div class="tv-show-wrapper">
            <!-- Header Board -->
            <header class="tv-header-widget">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="tv-title">
                        <i class="ti ti-flame fs-2"></i>
                        <span>Monitor Pelaksanaan Kremasi</span>
                    </div>
                    
                    <div class="d-flex align-items-center gap-4">
                        <div class="clock-container text-end">
                            <div id="live-clock">00:00:00</div>
                            <div id="live-date">Memuat tanggal...</div>
                        </div>
                        <button id="fullscreen-btn" class="btn btn-outline-light d-flex align-items-center gap-2" style="border-color: rgba(255, 255, 255, 0.15); color: var(--text-light); border-radius: 12px; padding: 10px 16px; font-weight: 500;">
                            <i class="ti ti-maximize fs-4"></i>
                            <span>Layar Penuh</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Screens Area -->
            <div class="slideshow-container-widget">
                @forelse($jadwals as $index => $jadwal)
                    <div class="slide-item glass-card @if($index === 0) active @endif" data-slide-index="{{ $index }}">
                        <div class="row g-5 align-items-center">
                            <!-- Column Photo -->
                            <div class="col-lg-5 photo-column">
                                <div class="photo-frame">
                                    @if($jadwal->foto_jenazah_url)
                                        <img src="{{ $jadwal->foto_jenazah_url }}" alt="Foto Jenazah {{ $jadwal->nama_pelanggan }}">
                                    @else
                                        <div class="photo-placeholder">
                                            <i class="ti ti-user-circle"></i>
                                            <span class="fs-5 mt-3 fw-medium">Foto Jenazah</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Column Details -->
                            <div class="col-lg-7 details-column">
                                <span class="badge-kremasi">
                                    <i class="ti ti-flame"></i> Sedang Di Kremasi
                                </span>
                                
                                <h2 class="deceased-name">{{ $jadwal->nama_pelanggan }}</h2>
                                
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Usia Jenazah</span>
                                        <div class="info-value">
                                            <i class="ti ti-hourglass-empty"></i>
                                            {{ $jadwal->umur ?? '-' }} Tahun
                                        </div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <span class="info-label">Tanggal Lahir</span>
                                        <div class="info-value">
                                            <i class="ti ti-calendar-event"></i>
                                            {{ $jadwal->pelanggan->tanggal_lahir ? \Carbon\Carbon::parse($jadwal->pelanggan->tanggal_lahir)->locale('id')->translatedFormat('d F Y') : '-' }}
                                        </div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <span class="info-label">Tanggal Meninggal</span>
                                        <div class="info-value">
                                            <i class="ti ti-calendar"></i>
                                            {{ \Carbon\Carbon::parse($jadwal->date)->locale('id')->translatedFormat('d F Y') }}
                                        </div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <span class="info-label">Ruangan / Mesin</span>
                                        <div class="info-value">
                                            <i class="ti ti-box"></i>
                                            Mesin {{ $jadwal->ruangan->nama ?? '-' }}
                                        </div>
                                    </div>
                                    
                                    <div class="info-item col-span-2" style="grid-column: span 2;">
                                        <span class="info-label">Waktu Pelaksanaan Kremasi</span>
                                        <div class="info-value text-warning">
                                            <i class="ti ti-clock"></i>
                                            {{ $jadwal->laporan ? \Carbon\Carbon::parse($jadwal->laporan->jam_awal)->format('H:i') : '-' }} WIB
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Standby View when No schedules -->
                    <div class="standby-container glass-card">
                        <i class="ti ti-flame standby-logo"></i>
                        <h2 class="standby-text text-white">Layanan Mandiri Krema Track</h2>
                        <p class="standby-subtext mb-0">
                            Tidak ada agenda pembakaran/kremasi jenazah yang sedang berlangsung saat ini. <br>
                            Layar monitor akan otomatis menampilkan informasi ketika proses kremasi dimulai.
                        </p>
                    </div>
                @endforelse

                <!-- Dot Indicators for slideshow -->
                @if($jadwals->count() > 1)
                    <div class="slideshow-dots">
                        @foreach($jadwals as $index => $jadwal)
                            <div class="dot @if($index === 0) active @endif" onclick="setSlide({{ $index }})"></div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');

    .tv-show-wrapper {
        --dark-bg: #090d16;
        --dark-card: rgba(17, 24, 39, 0.7);
        --primary-glow: rgba(43, 76, 111, 0.4);
        --accent-glow: rgba(217, 119, 6, 0.3);
        --text-light: #f8fafc;
        --text-muted: #94a3b8;
        --primary: #38bdf8;
        --accent: #f59e0b;

        font-family: 'Outfit', sans-serif;
        background-color: var(--dark-bg);
        background-image: 
            radial-gradient(at 0% 0%, var(--primary-glow) 0px, transparent 50%),
            radial-gradient(at 100% 100%, var(--accent-glow) 0px, transparent 50%);
        border-radius: 24px;
        color: var(--text-light);
        min-height: 75vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        position: relative;
    }

    /* Top Header Board */
    .tv-header-widget {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 20px 40px;
    }

    .tv-title {
        font-weight: 700;
        font-size: 1.6rem;
        letter-spacing: -0.5px;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .tv-title i {
        color: var(--accent);
        animation: pulse-flame 2s infinite ease-in-out;
    }

    @keyframes pulse-flame {
        0%, 100% { transform: scale(1); filter: drop-shadow(0 0 2px var(--accent)); }
        50% { transform: scale(1.1); filter: drop-shadow(0 0 10px var(--accent)); }
    }

    .clock-container {
        text-align: right;
    }

    #live-clock {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        letter-spacing: 0.5px;
        line-height: 1.2;
    }

    #live-date {
        font-size: 0.9rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Slideshow Layout */
    .slideshow-container-widget {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        position: relative;
        min-height: 500px;
    }

    .slide-item {
        width: 100%;
        max-width: 1200px;
        display: none;
        animation: fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
    }

    .slide-item.active {
        display: block;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .glass-card {
        background: var(--dark-card);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 32px;
        padding: 40px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    }

    /* Deceased Photo Section */
    .photo-column {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .photo-frame {
        width: 320px;
        height: 320px;
        border-radius: 24px;
        border: 4px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        background-color: rgba(15, 23, 42, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .photo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        animation: breathe 15s infinite ease-in-out;
    }

    @keyframes breathe {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .photo-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
    }

    .photo-placeholder i {
        font-size: 6rem;
        color: rgba(255, 255, 255, 0.15);
    }

    /* Details info area */
    .details-column {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-left: 20px;
    }

    .badge-kremasi {
        background: rgba(217, 119, 6, 0.15);
        color: var(--accent);
        border: 1px solid rgba(217, 119, 6, 0.3);
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        align-self: flex-start;
        margin-bottom: 16px;
        text-transform: uppercase;
    }

    .deceased-name {
        font-size: 2.8rem;
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1.1;
        margin-bottom: 20px;
        background: linear-gradient(to right, #ffffff, #cbd5e1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .info-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 14px 20px;
        border-radius: 16px;
    }

    .info-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        margin-bottom: 4px;
        display: block;
        font-weight: 500;
    }

    .info-value {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-light);
    }

    .info-value i {
        color: var(--primary);
        margin-right: 8px;
    }

    /* Standby state style */
    .standby-container {
        text-align: center;
        max-width: 700px;
        padding: 40px;
        animation: fadeInUp 0.8s ease-out;
    }

    .standby-logo {
        font-size: 4.5rem;
        color: var(--accent);
        margin-bottom: 24px;
        animation: pulse-flame 2.5s infinite ease-in-out;
        display: inline-block;
    }

    .standby-text {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .standby-subtext {
        font-size: 1rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* Slideshow Indicator Dots */
    .slideshow-dots {
        position: absolute;
        bottom: 25px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 10;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .dot.active {
        background-color: var(--primary);
        width: 24px;
        border-radius: 10px;
    }

    /* Fullscreen Mode Styling */
    .tv-show-wrapper:fullscreen {
        border-radius: 0 !important;
        border: none !important;
        width: 100vw !important;
        height: 100vh !important;
        max-width: none !important;
        max-height: none !important;
        padding: 0 !important;
        margin: 0 !important;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .tv-show-wrapper:fullscreen #fullscreen-btn {
        display: none !important;
    }

    .tv-show-wrapper:fullscreen .tv-header-widget {
        padding: 30px 60px !important;
    }

    .tv-show-wrapper:fullscreen .slideshow-container-widget {
        padding: 60px !important;
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tv-show-wrapper:fullscreen .slide-item {
        max-width: 1500px !important;
    }

    .tv-show-wrapper:fullscreen .photo-frame {
        width: 480px !important;
        height: 480px !important;
    }

    .tv-show-wrapper:fullscreen .deceased-name {
        font-size: 4.8rem !important;
        margin-bottom: 30px !important;
    }

    .tv-show-wrapper:fullscreen .badge-kremasi {
        font-size: 1.1rem !important;
        padding: 10px 24px !important;
        margin-bottom: 24px !important;
    }

    .tv-show-wrapper:fullscreen .info-grid {
        gap: 30px !important;
    }

    .tv-show-wrapper:fullscreen .info-item {
        padding: 20px 30px !important;
        border-radius: 20px !important;
    }

    .tv-show-wrapper:fullscreen .info-label {
        font-size: 1rem !important;
        margin-bottom: 8px !important;
    }

    .tv-show-wrapper:fullscreen .info-value {
        font-size: 1.8rem !important;
    }

    .tv-show-wrapper:fullscreen .slideshow-dots {
        bottom: 40px !important;
        gap: 15px !important;
    }

    .tv-show-wrapper:fullscreen .dot {
        width: 14px !important;
        height: 14px !important;
    }

    .tv-show-wrapper:fullscreen .dot.active {
        width: 32px !important;
    }
</style>

<script>
    // Live Date & Clock
    function updateClock() {
        const now = new Date();
        
        // Format Clock (HH:MM:SS)
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        const clockEl = document.getElementById('live-clock');
        if (clockEl) {
            clockEl.textContent = `${hours}:${minutes}:${seconds}`;
        }
        
        // Format Date (Day, Date Month Year)
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateEl = document.getElementById('live-date');
        if (dateEl) {
            dateEl.textContent = now.toLocaleDateString('id-ID', options);
        }
    }

    setInterval(updateClock, 1000);
    updateClock(); // Initial run

    // Slideshow Logic
    const slides = document.querySelectorAll('.slide-item');
    const dots = document.querySelectorAll('.dot');
    let currentSlideIndex = 0;
    const slideIntervalTime = 8000; // Switch slide every 8 seconds
    let slideTimer;

    function showSlide(index) {
        if (slides.length <= 1) return;

        // Deactivate current slide
        slides[currentSlideIndex].classList.remove('active');
        if (dots[currentSlideIndex]) dots[currentSlideIndex].classList.remove('active');

        // Set index
        currentSlideIndex = (index + slides.length) % slides.length;

        // Activate new slide
        slides[currentSlideIndex].classList.add('active');
        if (dots[currentSlideIndex]) dots[currentSlideIndex].classList.add('active');
    }

    function nextSlide() {
        showSlide(currentSlideIndex + 1);
    }

    window.setSlide = function(index) {
        clearInterval(slideTimer);
        showSlide(index);
        slideTimer = setInterval(nextSlide, slideIntervalTime);
    }

    if (slides.length > 1) {
        slideTimer = setInterval(nextSlide, slideIntervalTime);
    }

    // Fullscreen Logic
    const wrapper = document.querySelector('.tv-show-wrapper');
    const fullscreenBtn = document.getElementById('fullscreen-btn');

    if (fullscreenBtn && wrapper) {
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                wrapper.requestFullscreen().catch(err => {
                    alert(`Error attempting to enable fullscreen: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
        }

        fullscreenBtn.addEventListener('click', toggleFullscreen);

        // Track fullscreen change to update button icon and label
        document.addEventListener('fullscreenchange', () => {
            if (document.fullscreenElement === wrapper) {
                fullscreenBtn.innerHTML = '<i class="ti ti-minimize fs-4"></i> <span>Perkecil Layar</span>';
                fullscreenBtn.classList.remove('btn-outline-light');
                fullscreenBtn.classList.add('btn-light', 'text-dark');
            } else {
                fullscreenBtn.innerHTML = '<i class="ti ti-maximize fs-4"></i> <span>Layar Penuh</span>';
                fullscreenBtn.classList.remove('btn-light', 'text-dark');
                fullscreenBtn.classList.add('btn-outline-light');
            }
        });
    }

    // Auto Refresh Page every 1 minute to check for new active schedules (only if not in fullscreen)
    setTimeout(function() {
        if (!document.fullscreenElement) {
            window.location.reload();
        }
    }, 60000);
</script>
@endsection
