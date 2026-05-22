<!-- SIDEBAR -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
    
    .brand-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        font-family: 'Outfit', sans-serif;
    }
    
    .brand-logo-text {
        font-weight: 700;
        font-size: 1.35rem;
        color: #2b4c6f;
        letter-spacing: -0.5px;
        transition: transform 0.2s ease;
    }
    
    .brand-logo:hover .brand-logo-text {
        color: #1e3550;
    }
    
    .brand-logo i {
        font-size: 1.8rem;
        color: #d97706;
    }
</style>
<aside id="sidebar" class="sidebar">
<div class="logo-area">
    <a href="{{ url('/') }}" class="brand-logo">
        <i class="ti ti-flame"></i>
        <span class="brand-logo-text">Krema Track</span>
    </a>
</div>
<ul class="nav flex-column">
    <li class="px-4 py-2"><small class="nav-text">Main</small></li>
    
    @if(auth()->check() && (auth()->user()->role->nama === 'super_admin' || auth()->user()->role->nama === 'admin'))
        <li><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="ti ti-home"></i><span class="nav-text">Dashboard</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="ti ti-users"></i><span class="nav-text">Users</span></a></li>
    @elseif(auth()->check() && auth()->user()->role->nama === 'koor')
        <li><a class="nav-link {{ request()->routeIs('koor.dashboard') ? 'active' : '' }}" href="{{ route('koor.dashboard') }}"><i class="ti ti-home"></i><span class="nav-text">Dashboard</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('koor.users.*') ? 'active' : '' }}" href="{{ route('koor.users.index') }}"><i class="ti ti-users"></i><span class="nav-text">Users</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('laporan.create') ? 'active' : '' }}" href="{{ route('laporan.create') }}"><i class="ti ti-plus"></i><span class="nav-text">Add Laporan</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}" href="{{ route('laporan.index') }}"><i class="ti ti-receipt"></i><span class="nav-text">Laporan</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('laporan.bulanan') ? 'active' : '' }}" href="{{ route('laporan.bulanan') }}"><i class="ti ti-calendar"></i><span class="nav-text">Laporan Bulanan</span></a></li>
    @elseif(auth()->check() && auth()->user()->role->nama === 'karyawan')
        <li><a class="nav-link {{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}" href="{{ route('karyawan.dashboard') }}"><i class="ti ti-home"></i><span class="nav-text">Dashboard</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('karyawan.jadwal.*') ? 'active' : '' }}" href="{{ route('karyawan.jadwal.index') }}"><i class="ti ti-calendar-event"></i><span class="nav-text">Jadwal</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('karyawan.laporan.create') ? 'active' : '' }}" href="{{ route('karyawan.laporan.create') }}"><i class="ti ti-plus"></i><span class="nav-text">Add Laporan</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('karyawan.laporan.index') ? 'active' : '' }}" href="{{ route('karyawan.laporan.index') }}"><i class="ti ti-receipt"></i><span class="nav-text">Laporan</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('karyawan.laporan.bulanan') ? 'active' : '' }}" href="{{ route('karyawan.laporan.bulanan') }}"><i class="ti ti-calendar"></i><span class="nav-text">Laporan Bulanan</span></a></li>
    @endif

    <li class="px-4 pt-4 pb-2"><small class="nav-text">Account</small></li>
    <li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="ti ti-logout"></i><span class="nav-text">Log out</span>
            </a>
        </form>
    </li>

</aside>