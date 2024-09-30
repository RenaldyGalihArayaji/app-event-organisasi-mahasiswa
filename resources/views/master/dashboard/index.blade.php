@extends('master.layout.index')

@section('content')
    
    <div class="main-content">
        <div class="title">
          <h1 class="h3 mb-0 ">Dashboard</h1>
        </div>
        <div class="content-wrapper">
            <div class="row same-height"> 

              {{-- Event AKtif --}}
              @can('Event-Active dashboard')
                <div class="col-md-3">
                    <div class="card border-0  h-100 py-3" style="border-radius: 15px; overflow: hidden;"> 
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                            <h5><strong>Event Aktif</strong></h5>
                            <div class="fs-4 mb-0 font-weight-bold ">{{ $eventActive}}</div>
                          </div>
                          <div class="col-auto">
                            <i class="ti-calendar fa-2x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              @endcan
              
              {{-- Event Non Aktif --}}
              @can('Event-Inactive dashboard')
                <div class="col-md-3">
                  <div class="card border-0  h-100 py-3" style="border-radius: 15px; overflow: hidden;"> 
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <h5><strong>Event Non-Aktif</strong></h5>
                          <div class="fs-4 mb-0 font-weight-bold ">{{ $eventInactive}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="ti-calendar fa-2x"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
              @endcan

              {{-- Event Diajukan --}}
              @can('Event-Waiting dashboard')
                <div class="col-md-3">
                  <div class="card border-0  h-100 py-3" style="border-radius: 15px; overflow: hidden;"> 
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <h5><strong>Event Diajukan</strong></h5>
                          <div class="fs-4 mb-0 font-weight-bold ">{{ $submissionEvent_waiting}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="ti-zip fa-2x"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
              @endcan

              {{-- Event Ditolak --}}
              @can('Event-Rejected dashboard')
                <div class="col-md-3">
                  <div class="card border-0  h-100 py-3" style="border-radius: 15px; overflow: hidden;"> 
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <h5><strong>Event Ditolak</strong></h5>
                          <div class="fs-4 mb-0 font-weight-bold ">{{ $submissionEvent_rejected}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="ti-zip fa-2x"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endcan
              
              {{-- Event Diterima dan dipublish --}}
              @can('Event-Approved dashboard')
                <div class="col-md-3">
                  <div class="card border-0  h-100 py-3" style="border-radius: 15px; overflow: hidden;"> 
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <h5><strong>Event Diterima/Publish</strong></h5>
                          <div class="fs-4 mb-0 font-weight-bold ">{{ $submissionEvent_approved}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="ti-zip fa-2x"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endcan
              
              {{-- Laporan Diajukan --}}
              @can('Report-Waiting dashboard')
                <div class="col-md-3">
                  <div class="card border-0  h-100 py-3" style="border-radius: 15px; overflow: hidden;"> 
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <h5><strong>Laporan Diajukan</strong></h5>
                          <div class="fs-4 mb-0 font-weight-bold ">{{ $report_waiting}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="ti-layout-column2 fa-2x"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
              @endcan

              {{-- Laporan Ditolak --}}
              @can('Report-Rejected dashboard')
                <div class="col-md-3">
                  <div class="card border-0  h-100 py-3" style="border-radius: 15px; overflow: hidden;"> 
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <h5><strong>Laporan Ditolak</strong></h5>
                          <div class="fs-4 mb-0 font-weight-bold ">{{ $report_rejected}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="ti-layout-column2 fa-2x"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
              @endcan

              {{-- Laporan Diterima --}}
              @can('Report-Approved dashboard')
                <div class="col-md-3">
                  <div class="card border-0  h-100 py-3" style="border-radius: 15px; overflow: hidden;"> 
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <h5><strong>Laporan Diterima</strong></h5>
                          <div class="fs-4 mb-0 font-weight-bold ">{{ $report_approved}}</div>
                        </div>
                        <div class="col-auto">
                          <i class="ti-layout-column2 fa-2x"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
              @endcan

              {{-- Sponsorship --}}
              @php
                  $amount = 0;
                  $sponsorships = \App\Models\Sponsorship::where('user_id', Auth::user()->id)->get();
                  foreach ($sponsorships as $sponsorship) {
                  $amount += $sponsorship->amount;}
              @endphp

              @can('view sponsorship')
                <div class="col-md-3">
                  <div class="card border-0  h-100 py-3" style="border-radius: 15px; overflow: hidden;"> 
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <h5><strong>Dana Sponsor</strong></h5>
                          <div class="fs-4 mb-0">@currency($amount)</div>
                        </div>
                        <div class="col-auto">
                          <i class="ti-money fa-2x"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
              @endcan
              
            </div>

            <div class="row">

              
              <div class="col-md-5">

                <div class="row">
                 
                  <div class="col-md-12">
                    {{-- Tampilan Event Yang Sedang Berlangsung --}}
                    <div class="card border-0 py-3" style="border-radius: 15px; overflow: hidden;"> 
                      <div class="card-body">
                        <h5 class="text-center"><strong>- Event Sedang Berlangsung -</strong></h5>   
                        <div class="p-3">
                          @if($ongoingEvent->isEmpty())
                              <div class="text-center" style="background-color: #eeebebfa; border-radius: 15px; overflow: hidden;"">
                                  <p class="text-dark-emphasis mt-3"><strong>Belum ada event.</strong></p>
                              </div>
                          @else
                              @foreach ($ongoingEvent as $item)
                                  <div class="row mb-3" data-aos="fade-up" data-aos-delay="100">
                                      <div class="col-4">
                                          <img src="{{ asset('storage/image-events/'. $item->event_image) }}" class="img-fluid rounded" alt="{{ $item->event_name }}" style="height: 100px; width: 20vh; object-fit: cover;">
                                      </div>
                                      <div class="col-8">
                                          <h6 class="mb-1"><strong>{{ ucwords($item->event_name) }}</strong></h6>
                                          <p class="mb-0" style="font-size: 13px">
                                              @if (date("d F Y", strtotime($item->start_date)) == date("d F Y", strtotime($item->end_date)))
                                                  <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y ", strtotime($item->start_date)) }}</span><br>
                                                  <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - {{ date("H:i", strtotime($item->end_date)) }} WIB</span>
                                              @else
                                                  <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y", strtotime($item->start_date)) }} - {{ date("d F Y", strtotime($item->end_date)) }}</span><br>
                                                  <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - {{ date("H:i", strtotime($item->end_date)) }} WIB</span>
                                              @endif
                                          </p>
                                      </div>
                                  </div>
                              @endforeach
                          @endif
                        </div>                  
                      </div>
                    </div>
                  </div>
          
                  <div class="col-md-12">
                    {{-- Pengajuan Event Deadline --}}
                    <div class="card border-0 py-3" style="border-radius: 15px; overflow: hidden;"> 
                      <div class="card-body">
                          <h5 class="text-center"><strong>- Batas Waktu Pengajuan Event -</strong></h5>   
                          <div class="p-3">
                            @foreach ($eventDeadline as $item)
                                @if ((Carbon\Carbon::parse($item->submissionEvent->deadline)->diffInDays(now()) <= 5 && 
                                      Carbon\Carbon::parse($item->submissionEvent->deadline) >= now()))
                                      @if ($item->submissionEvent->submission_status == 'waiting' )
                                        <div class="row mb-3 align-items-center" style="background-color: #f9f9f9; border-radius: 10px; padding: 10px;">
                                          <div class="col-7">
                                              <h5 class="mb-1"><strong>{{ ucwords($item->event_name) }}</strong></h5>
                                              <h6 class="mb-1"><strong>{{ ucwords($item->organization->name) }}</strong></h6>
                                              <p class="mb-0 text-muted" style="font-size: 13px;">
                                                  Tanggal Pengajuan: {{ date('d F Y', strtotime($item->created_at)) }}<br>
                                                  Batas Pengajuan: {{ date('d F Y', strtotime($item->submissionEvent->deadline)) }}
                                              </p>
                                          </div>
                                          <div class="col-5 text-end">
                                              @if(auth()->user()->hasRole('super admin'))
                                                  <a href="{{ route('event.index') }}" class="btn btn-danger btn-sm px-3">Lihat Pengajuan</a>
                                              @else
                                                  @php
                                                      $setting = DB::table('settings')->first();
                                                      $whatsappLink = "https://api.whatsapp.com/send/?phone=" . $setting->contact_phone . "&text&type=phone_number&app_absent=0";
                                                  @endphp
                                                  <a href="{{ $whatsappLink }}" target="_blank" 
                                                    class="btn btn-success btn-sm px-3" 
                                                    style="background-color: #25D366; color: white;">
                                                    <i class="bi bi-whatsapp"></i> Hubungi Super Admin
                                                  </a>
                                              @endif
                                          </div>
                                        </div>
                                      @endif
                                @endif
                            @endforeach
                          </div>                  
                      </div>
                    </div>
                  </div>
                  
                  {{-- Pengajuan Laporan Deadline --}}
                  <div class="col-md-12">
                    <div class="card border-0 py-3" style="border-radius: 15px; overflow: hidden;"> 
                      <div class="card-body">
                          <h5 class="text-center"><strong>- Batas Waktu Pengajuan Laporan -</strong></h5>   
                          <div class="p-3">
                            @foreach ($reportDeadline as $item)    
                              @if (Carbon\Carbon::parse($item->deadline)->diffInDays(now()) > 7)
                                @if ($item->status == 'waiting' ) 
                                  <div class="row mb-3 align-items-center" style="background-color: #f9f9f9; border-radius: 10px; padding: 10px;">
                                    <div class="col-7">
                                        <h5 class="mb-1"><strong>{{ ucwords($item->event) }}</strong></h5>
                                        <h6 class="mb-1"><strong>{{ ucwords($item->organization) }}</strong></h6>
                                        <p class="mb-0 text-muted" style="font-size: 13px;">
                                            Tanggal Pengajuan: {{ date('d F Y', strtotime($item->created_at)) }}<br>
                                            Batas Pengajuan: {{ date('d F Y', strtotime($item->deadline)) }}
                                        </p>
                                    </div>
                                    <div class="col-5 text-end">
                                        @if(auth()->user()->hasRole('super admin'))
                                            <a href="{{ route('report.index') }}" class="btn btn-danger btn-sm px-3">Lihat Laporan</a>
                                        @else
                                            @php
                                                $setting = DB::table('settings')->first();
                                                $whatsappLink = "https://api.whatsapp.com/send/?phone=" . $setting->contact_phone . "&text&type=phone_number&app_absent=0";
                                            @endphp
                                            <a href="{{ $whatsappLink }}" target="_blank" 
                                              class="btn btn-success btn-sm px-3" 
                                              style="background-color: #25D366; color: white;">
                                              <i class="bi bi-whatsapp"></i> Hubungi Super Admin
                                            </a>
                                        @endif
                                    </div>
                                  </div>
                                @endif
                              @endif
                            @endforeach
                          </div>                  
                      </div>
                    </div>
                  </div>

                </div>
              
              </div>

             
              <div class="col-md-7">
                <div class="row">

                  <div class="col-md-12">
                    <div class="card border-0 py-3" style="border-radius: 15px; overflow: hidden;"> 

                      <div class="card-body">
                        <h5 class="text-center"><strong>- Penyelenggara Belum Melakukan Pengajuan Laporan -</strong></h5>
                        <div class="p-3">
                            {{-- Menampilkan event yang belum melakukan pengajuan laporan jika nama event sama dengan nama di laporan --}}
                            @php
                                // Menampilkan semua event jika user memiliki role 'super-admin', jika tidak hanya menampilkan event sesuai user/akun
                                $eventDash = Auth::user()->hasRole('super admin')
                                    ? \App\Models\Event::with('organization')->get()
                                    : \App\Models\Event::with('organization')->where('user_id', Auth::user()->id)->get();
                    
                                // Mengambil nilai deadline dari tabel settings
                                $setting = DB::table('settings')->where('id', 1)->first();
                                $deadline_days = $setting->deadline; // Mengambil nilai deadline dari tabel settings
                    
                                // Mengambil nama event yang sudah ada di laporan
                                $reportDash = \App\Models\ReportEvent::pluck('event'); 
                            @endphp
                    
                            {{-- Cek apakah nilai deadline_days ada --}}
                            <table id="example2" class="table dt-responsive display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Poster</th>
                                        <th>Nama Event</th>
                                        <th>Penyelenggara</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($eventDash as $item)
                                        {{-- Cek apakah nama event belum ada di laporan, apakah event sudah berakhir, dan apakah sudah melewati deadline dari tabel settings --}}
                                        @if (
                                            !$reportDash->contains($item->event_name) && 
                                            $item->end_date <= now() && 
                                            now()->diffInDays($item->end_date) > $deadline_days
                                        )
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/image-events/' . $item->event_image) }}" alt="" width="40">
                                                </td>
                                                <td>{{ ucwords($item->event_name) }}</td>
                                                <td>{{ ucwords($item->organization->name) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                     </div>
                    

                    </div>
                  </div>

                   {{-- Tampilan Kalender --}}
                  <div class="col-md-12">
                    <div class="card border-0 py-3" style="border-radius: 15px; overflow: hidden;"> 
                      <div class="card-body">
                        <h5 class="text-center"><strong>- Kalender Event -</strong></h5>  
                        <div class="p-3">
                          <div id="calendar"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('template-admin/vendor/fullcalendar/index.global.min.js')}}"></script>
    <script src='{{ asset('template-admin/vendor/@fullcalendar/bootstrap5/index.global.min.js')}}'></script>
    <script src="{{ asset('template-admin/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('template-admin/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('template-admin/vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('template-admin/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('template-admin//assets/js/pages/datatables.min.js')}}"></script>
    <script>
      DataTable.init()
    </script>


    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            const today = new Date()

            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap5',
                initialView: 'dayGridMonth',
                editable: true,
                headerToolbar: {
                    // left: 'prev,next today',
                    // center: 'title',
                    // right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [ 
                    @foreach ($events as $item)
                    {
                        id: '{{ $item->id }}',
                        title: '{{ $item->event_name }}',
                        start: '{{ $item->start_date }}',
                        end: '{{ $item->end_date }}',
                    },
                    @endforeach
                ],
                weekNumbers: true,
                selectable:true,
                dayMaxEvents: true,
            });
            calendar.render();
            calendar.setOption('locale', 'id');
        });

    </script>
@endpush

