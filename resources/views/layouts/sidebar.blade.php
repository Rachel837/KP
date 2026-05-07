<!-- SIDEBAR -->
<aside id="sidebar" class="sidebar">
<div class="logo-area">
    {{-- <a href="index.html" class="d-inline-flex"><img src="{{ asset('assets/images/logo-icon.svg') }}" alt="" width="24"> --}}
    <span class="logo-text ms-2"> <img src="{{ asset('assets/images/logo.png') }}" alt=""></span>
    </a>
</div>
<ul class="nav flex-column">
    <li class="px-4 py-2"><small class="nav-text">Main</small></li>
    
    @if(auth()->check() && (auth()->user()->role->nama === 'super_admin' || auth()->user()->role->nama === 'admin'))
        <li><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="ti ti-home"></i><span class="nav-text">Dashboard</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="ti ti-users"></i><span class="nav-text">Users</span></a></li>
    @elseif(auth()->check() && auth()->user()->role->nama === 'koor')
        <li><a class="nav-link {{ request()->routeIs('koor.dashboard') ? 'active' : '' }}" href="{{ route('koor.dashboard') }}"><i class="ti ti-home"></i><span class="nav-text">Dashboard</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('laporan.create') ? 'active' : '' }}" href="{{ route('laporan.create') }}"><i class="ti ti-plus"></i><span class="nav-text">Add Laporan</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}" href="{{ route('laporan.index') }}"><i class="ti ti-receipt"></i><span class="nav-text">Laporan</span></a></li>
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