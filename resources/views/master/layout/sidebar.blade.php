@php
    $setting = DB::table('settings')->where('id',1)->first();
@endphp
<nav class="main-sidebar ps-menu">
    <div class="sidebar-header">
        <div class="text">{{ ucwords($setting->app_name)}}</div>
        <div class="close-sidebar action-toggle">
            <i class="ti-close"></i>
        </div>
    </div>
    <div class="sidebar-content">
        <ul>
            <li class="{{ Request::segment(1) == 'dashboard' ? 'active open' : ''}}">
                <a href="{{ route('dashboard')}}" class="link">
                    <i class="ti-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="menu-category">
                <span class="text-uppercase">User Interface</span>
            </li>

            @if (Auth::check() && Auth::user()->can('view role') || Auth::user()->can('view user') || Auth::user()->can('view organization'))
            <li class="{{ Request::segment(1) == 'configuration' ? 'active open' : ''}}">
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-layout-grid2"></i>
                    <span>Konfigurasi</span>
                </a>
                <ul class="sub-menu ">
                    @can('view organization')
                    <li class="{{ Request::segment(2) == 'organization' ? 'active' : ''}}"><a href="{{ route('organization.index')}}" class="link"><span>Kelola Organisasi</span></a></li> 
                    @endcan
                    @can('view role')
                    <li class="{{ Request::segment(2) == 'role' ? 'active' : ''}}"><a href="{{ route('role.index')}}" class="link"><span>Kelola Role</span></a></li> 
                    @endcan
                    @can('view user')
                    <li class="{{ Request::segment(2) == 'user' ? 'active' : ''}}"><a href="{{ route('user.index')}}" class="link"><span>Kelola User</span></a></li>
                    @endcan
                </ul>
            </li>
            @endif

            @if (Auth::check() && (Auth::user()->can('view category') || Auth::user()->can('view event') || Auth::user()->can('view sponsorship')))
            <li class="{{ Request::segment(1) == 'component' ? 'active open' : ''}}">
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-panel"></i>
                    <span>Komponen</span>
                </a>
                <ul class="sub-menu ">

                    @can('view category')
                    <li class="{{ Request::segment(2) == 'category' ? 'active' : ''}}"><a href="{{ route('category.index')}}" class="link"><span>Kategori Event</span></a></li> 
                    @endcan

                    @can('view event')
                    <li class="{{ Request::segment(2) == 'event' ? 'active' : ''}}"><a href="{{ route('event.index')}}" class="link"><span>Pengajuan Event</span></a></li>    
                    @endcan

                    @can('view sponsorship')
                    <li class="{{ Request::segment(2) == 'sponsorship' ? 'active' : ''}}"><a href="{{ route('sponsorship.index')}}" class="link"><span>Kelola Sponsorship</span></a></li>    
                    @endcan
                </ul>
            </li>
            @endif

            @can('view participant')
            <li class="{{ Request::segment(1) == 'participant' ? 'active open' : ''}}">
                <a href="{{ route('participant.index')}}" class="link">
                    <i class="ti-agenda"></i>
                    <span>Data Peserta</span>
                </a>
            </li>
            @endcan

            @can('view calendar')
            <li class="{{ Request::segment(1) == 'calendar' ? 'active open' : ''}}">
                <a href="{{ route('calendar')}}" class="link">
                    <i class="ti-calendar"></i>
                    <span>Kalender Event</span>
                </a>
            </li>     
            @endcan

            @can('view report')
                <li class="{{ Request::segment(1) == 'report' ? 'active' : ''}}">
                    <a href="{{ route('report.index')}}" class="link">
                        <i class="ti-layout-column2"></i>
                        <span>Laporan Event</span>
                    </a>
                </li>   
            @endcan
        </ul>
    </div>
</nav> 