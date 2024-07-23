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

              
              {{-- Tampilan Event Yang Sedang Berlangsung --}}
              <div class="col-md-4">
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

              {{-- Tampilan Kalender --}}
              <div class="col-md-8">
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

@endsection

@push('scripts')
    <script src="{{ asset('template-admin/vendor/fullcalendar/index.global.min.js')}}"></script>
    <script src='{{ asset('template-admin/vendor/@fullcalendar/bootstrap5/index.global.min.js')}}'></script>

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

