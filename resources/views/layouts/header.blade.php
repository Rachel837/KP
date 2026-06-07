<!-- TOPBAR -->
<nav id="topbar" class="navbar bg-white border-bottom fixed-top topbar px-3">
<button id="toggleBtn" class="d-none d-lg-inline-flex btn btn-light btn-icon btn-sm ">
    <i class="ti ti-layout-sidebar-left-expand"></i>
</button>

<!-- MOBILE -->
<button id="mobileBtn" class="btn btn-light btn-icon btn-sm d-lg-none me-2">
    <i class="ti ti-layout-sidebar-left-expand"></i>
</button>
<div>
    <!-- Navbar nav -->
    <ul class="list-unstyled d-flex align-items-center mb-0 gap-1">
    <!-- Pages link -->

    <!-- Bell icon -->
    @php
        $recentJadwals = \App\Models\Jadwal::with('ruangan')->orderBy('idreports', 'desc')->take(5)->get();
        $latestJadwalId = $recentJadwals->first()->idreports ?? 0;
    @endphp
    <li class="dropdown">
        <a class="position-relative btn-icon btn-sm btn-light btn rounded-circle" data-bs-toggle="dropdown"
        aria-expanded="false" href="#" role="button" id="notificationBell" data-latest-id="{{ $latestJadwalId }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-bell">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
        </svg>
        <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger mt-2 ms-n2" style="display: none;">
            0
            <span class="visually-hidden">unread messages</span>
        </span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-0" style="min-width: 320px;">
            <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center bg-light">
                <span class="fw-bold text-dark small">Notifikasi Jadwal Baru</span>
                <span class="badge bg-warning bg-opacity-10 text-warning small">Terbaru</span>
            </div>
            <ul class="list-unstyled p-0 m-0" style="max-height: 350px; overflow-y: auto;">
                @forelse($recentJadwals as $recentJadwal)
                    <li class="p-3 border-bottom notification-item" data-id="{{ $recentJadwal->idreports }}">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0;">
                                <i class="ti ti-calendar-event fs-5"></i>
                            </div>
                            <div class="flex-grow-1 small">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0 fw-semibold text-dark">{{ $recentJadwal->nama_pelanggan }}</p>
                                    <span class="unread-dot bg-danger rounded-circle" style="width: 8px; height: 8px; display: none;"></span>
                                </div>
                                <p class="mb-1 text-muted" style="font-size: 0.8rem;">Jadwal baru ditambahkan.</p>
                                <div class="d-flex align-items-center gap-2 mt-1 text-secondary" style="font-size: 0.75rem;">
                                    <i class="ti ti-clock"></i>
                                    <span>{{ \Carbon\Carbon::parse($recentJadwal->jam_awal)->format('H:i') }} - Mesin {{ $recentJadwal->ruangan->nama ?? '-' }}</span>
                                </div>
                                <div class="text-secondary mt-1" style="font-size: 0.7rem;">
                                    Tanggal: {{ \Carbon\Carbon::parse($recentJadwal->date)->locale('id')->translatedFormat('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="p-4 text-center text-muted small">
                        <i class="ti ti-bell-off fs-4 d-block mb-2 text-secondary"></i>
                        Belum ada notifikasi jadwal.
                    </li>
                @endforelse
            </ul>
            @if($recentJadwals->count() > 0)
                <div class="p-2 border-top text-center bg-light">
                    @php
                        $routeTarget = '#';
                        if (auth()->check()) {
                            $role = auth()->user()->role->nama ?? '';
                            if ($role === 'karyawan') {
                                $routeTarget = route('karyawan.jadwal.index');
                            } elseif ($role === 'koor') {
                                $routeTarget = route('karyawan.laporan.index');
                            }
                        }
                    @endphp
                    <a href="{{ $routeTarget }}" class="text-primary small fw-semibold text-decoration-none">Lihat Semua Jadwal</a>
                </div>
            @endif
        </div>
    </li>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bell = document.getElementById('notificationBell');
            const badge = document.getElementById('notificationBadge');
            if (!bell || !badge) return;

            const latestId = parseInt(bell.getAttribute('data-latest-id')) || 0;
            const lastSeenId = parseInt(localStorage.getItem('last_seen_jadwal_id')) || 0;

            // Calculate count of new notifications
            let unreadCount = 0;
            const items = document.querySelectorAll('.notification-item');
            items.forEach(item => {
                const itemId = parseInt(item.getAttribute('data-id'));
                if (itemId > lastSeenId) {
                    unreadCount++;
                    item.classList.add('bg-light');
                    const dot = item.querySelector('.unread-dot');
                    if (dot) dot.style.display = 'block';
                } else {
                    const dot = item.querySelector('.unread-dot');
                    if (dot) dot.style.display = 'none';
                }
            });

            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }

            // When dropdown is shown, mark all as read
            bell.addEventListener('click', function() {
                localStorage.setItem('last_seen_jadwal_id', latestId);
                setTimeout(() => {
                    badge.style.display = 'none';
                    items.forEach(item => {
                        item.classList.remove('bg-light');
                        const dot = item.querySelector('.unread-dot');
                        if (dot) dot.style.display = 'none';
                    });
                }, 1000);
            });
        });
    </script>
    <!-- Dropdown -->
    <li class="ms-3 dropdown">
        <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="d-inline-flex align-items-center">
            @if(isset(Auth::user()->foto) && Auth::user()->foto)
                <img src="{{ asset(Auth::user()->foto) }}" alt="" class="avatar avatar-sm rounded-circle" />
            @else
                <span class="d-inline-flex align-items-center justify-content-center bg-light text-secondary rounded-circle" style="width: 35px; height: 35px; border: 1px solid #e2e8f0;">
                    <i class="ti ti-user fs-4"></i>
                </span>
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-end p-0" style="min-width: 220px; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);">
            <div>
                <div class="d-flex gap-3 align-items-center border-bottom px-3 py-3 bg-light">
                    @if(isset(Auth::user()->foto) && Auth::user()->foto)
                        <img src="{{ asset(Auth::user()->foto) }}" alt="" class="avatar avatar-md rounded-circle" />
                    @else
                        <span class="d-inline-flex align-items-center justify-content-center bg-white text-secondary rounded-circle" style="width: 45px; height: 45px; border: 1px solid #e2e8f0; flex-shrink: 0;">
                            <i class="ti ti-user fs-3"></i>
                        </span>
                    @endif
                    <div>
                        <h4 class="mb-0 small fw-bold text-dark">{{ Auth::user()->name }}</h4>
                        <p class="mb-0 text-muted small" style="font-size: 0.8rem;">{{ Auth::user()->role->nama === 'koor' ? Auth::user()->email : (Auth::user()->username ? '@' . Auth::user()->username : Auth::user()->email) }}</p>
                    </div>
                </div>
                <div class="p-2 d-flex flex-column gap-1 small">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 rounded-2 text-secondary" style="transition: all 0.2s;">
                        <i class="ti ti-settings fs-5"></i>
                        <span>Account Settings</span>
                    </a>
                </div>
            </div>
        </div>
    </li>
    </ul>
</div>

</nav>