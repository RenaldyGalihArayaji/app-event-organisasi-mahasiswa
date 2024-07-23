<header class="header-navbar fixed">
    <div class="header-wrapper">
        <div class="header-left">
            <div class="sidebar-toggle action-toggle"><i class="fas fa-bars"></i></div>
            
        </div>
        <div class="header-content">
            <div class="theme-switch-icon"></div>
            
            <div class="notification dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-bell"></i>
                    <span class="badge">
                        <?php
                        $user = Auth::user();
                        $isSuperAdmin = $user->hasRole('super admin');
                        
                        $submissionEventCount = $isSuperAdmin 
                            ? \App\Models\SubmissionEvent::where('submission_status', 'waiting')->count() 
                            : \App\Models\SubmissionEvent::where('user_id', $user->id)
                                                          ->whereIn('submission_status', ['waiting', 'rejected'])
                                                          ->count();
                    
                        $ReportEventCount = $isSuperAdmin 
                            ? \App\Models\ReportEvent::where('status', 'waiting')->count() 
                            : \App\Models\ReportEvent::where('user_id', $user->id)
                                                          ->whereIn('status', ['waiting', 'rejected'])
                                                          ->count();
                    
                        echo $submissionEventCount + $ReportEventCount;
                    ?>                    
                    </span>
                </a>
                <ul class="dropdown-menu medium">
                    <li class="menu-header">
                        <a class="dropdown-item" href="#">Notifikasi</a>
                    </li>
                    <li class="menu-content ps-menu">
                        @php
                        $user = Auth::user();
                        $isSuperAdmin = $user->hasRole('super admin');
                    
                        $notif_SubmissionEvent = $isSuperAdmin 
                            ? \App\Models\SubmissionEvent::where('submission_status', 'waiting')->latest()->paginate(3) 
                            : \App\Models\SubmissionEvent::where('user_id', $user->id)
                                                         ->whereIn('submission_status', ['waiting', 'rejected', 'approved'])
                                                         ->latest()
                                                         ->paginate(3);
                    
                        $notif_ReportEvent = $isSuperAdmin 
                            ? \App\Models\ReportEvent::where('status', 'waiting')->latest()->paginate(3) 
                            : \App\Models\ReportEvent::where('user_id', $user->id)
                                                         ->whereIn('status', ['waiting', 'rejected', 'approved'])
                                                         ->latest()
                                                         ->paginate(3);
                        @endphp
                    
                        @foreach($notif_SubmissionEvent as $n)
                            <a href="{{ route('event.index') }}">
                                <div class="message-icon">
                                    @if($n->submission_status == 'waiting')
                                        <i class="fas fa-info text-warning"></i>
                                    @elseif($n->submission_status == 'rejected')
                                        <i class="fas fa-exclamation-triangle text-danger"></i>
                                    @elseif($n->submission_status == 'approved')
                                        <i class="fas fa-check text-success"></i>
                                    @endif
                                </div>
                                <div class="message-content read">
                                    <div class="body">
                                        @if($n->submission_status == 'waiting')
                                            Menunggu Konfirmasi
                                        @elseif($n->submission_status == 'rejected')
                                            Pengajuan Ditolak: {{ $n->submission_note }}
                                        @elseif($n->submission_status == 'approved')
                                            Pengajuan Diterima dan Publish{{ $n->submission_note ? ': '.$n->submission_note : '' }}
                                        @endif
                                    </div>
                                    <div class="time">
                                        {{ \Carbon\Carbon::parse($n->created_at)->setTimezone('Asia/Jakarta')->locale('id_ID')->translatedFormat('d F Y H:i') }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                
                        @foreach($notif_ReportEvent as $n)
                            <a href="{{ route('report.index') }}">
                                <div class="message-icon">
                                    @if($n->status == 'waiting')
                                        <i class="fas fa-info text-warning"></i>
                                    @elseif($n->status == 'rejected')
                                        <i class="fas fa-exclamation-triangle text-danger"></i>
                                    @elseif($n->status == 'approved')
                                        <i class="fas fa-check text-success"></i>
                                    @endif
                                </div>
                                <div class="message-content read">
                                    <div class="body">
                                        @if($n->status == 'waiting')
                                            Menunggu Konfirmasi
                                        @elseif($n->status == 'rejected')
                                            Dokumen laporan Ditolak: {{ $n->note }}
                                        @elseif($n->status == 'approved')
                                            Dokumen laporan Diterima{{ $n->note ? ': '.$n->note : '' }}
                                        @endif
                                    </div>
                                    <div class="time">
                                        {{ \Carbon\Carbon::parse($n->created_at)->setTimezone('Asia/Jakarta')->locale('id_ID')->translatedFormat('d F Y H:i') }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </li>
                </ul>          
                
            </div>
            
            <div class="dropdown dropdown-menu-end">
                <a href="#" class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="label">
                        <span></span>
                        <div>{{ ucwords(Auth::user()->name)}}</div>
                    </div>
                    <img class="img-fluid rounded-circle" src="{{ asset('storage/image-profil/'. Auth::user()->image)}}" alt="user" style=" width: 5vh; height: 5vh; background-size: cover;">
                </a>
                <ul class="dropdown-menu small">
                    <li class="menu-content ps-menu">
                        <a href="{{ route('profil')}}">
                            <div class="description">
                                <i class="ti-user"></i> Profile
                            </div>
                        </a>
                        @can('update setting')
                            <a href="{{ route('setting')}}">
                                <div class="description">
                                    <i class="ti-settings"></i> Setting
                                </div>
                            </a>
                        @endcan
                        <a href="{{ route('logout')}}">
                            <div class="description">
                                <i class="ti-power-off"></i> Logout
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</header>
