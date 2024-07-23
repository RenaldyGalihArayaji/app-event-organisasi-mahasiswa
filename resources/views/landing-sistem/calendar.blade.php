@extends('landing-sistem.layout.index')

@section('content')

    <div class="page-title" data-aos="fade">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Kalender Event</h1>
            <nav class="breadcrumbs">
                <ol>
                <li><a href="{{ route('home')}}" class="text-dark">Beranda</a></li>
                <li class="current text-primary">Kalender Event</li>
                </ol>
            </nav>
        </div>
    </div>

    <section id="documentation" class="documentation section mt-5">
        <div class="container section-title" data-aos="fade-up">
          <h2>Info</h2>
          <p><span>Kalender</span> <span class="description-title">Event</span></p>
        </div>
  
        <div class="container">
          <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card p-3">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    @foreach ($event as $events)
                    {
                        id: '{{ $events->id }}',
                        title: '{{ $events->event_name }}',
                        start: '{{ $events->start_date }}',
                        end: '{{ $events->end_date }}',
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