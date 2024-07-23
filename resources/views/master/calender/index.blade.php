@extends('master.layout.index')

@section('content')
    
<div class="main-content">
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Kalender Event</h1>
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="col-md-12">
                        <div id="calendar"></div>
                    </div>
                    {{-- <div class="col-md-2">
                        <div id='external-events'></div>
                    </div> --}}
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
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [ 
                    @foreach ($events as $event)
                    {
                        id: '{{ $event->id }}',
                        title: '{{ $event->event_name }}',
                        start: '{{ $event->start_date }}',
                        end: '{{ $event->end_date }}',
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
