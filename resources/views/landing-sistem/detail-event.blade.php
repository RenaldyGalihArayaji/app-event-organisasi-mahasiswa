@extends('landing-sistem.layout.index')

@section('content')

    <div class="page-title" data-aos="fade">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Detail Event | <span class="text-secondary fs-6">{{ ucwords($event->event_name)}}</span></h1>
            <nav class="breadcrumbs">
                <ol>
                <li><a href="{{ route('home')}}" class="text-dark">Beranda</a></li>
                <li class="current text-primary">Detail Event</li>
                </ol>
            </nav>
        </div>
    </div>

    <section id="event-details" class="event-details section ">

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4 mb-5">
                <div class="col-md-8">
                    <div class="card mb-3 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                        <img src="{{ asset('storage/image-events/'. $event->event_image )}}" alt="Event Image" class="img-fluid card-img-top p-3 rounded" style="object-fit: cover; object-position: center">
                        <div class="card-body" style="padding: 1.5rem;">
                            <h3 class="card-title" style="font-size: 1.5rem;font-weight: bold;">{{ ucwords($event->event_name)}}</h3>
                            <div class="d-flex flex-wrap mb-3">
                                <span class="badge bg-primary me-2 mb-2" style="font-size: 0.7rem; padding: 0.5rem;"><i class="bi bi-tag"></i> {{ ucwords($event->category->name)}}</span>
                                <span class="badge bg-success me-2 mb-2" style="font-size: 0.7rem; padding: 0.5rem;"><i class="bi bi-globe"></i> {{ $event->activity == 'online' ? 'Online' : 'Offline' }}</span>
                                @if ($event->method_type == 'paid')
                                    <span class="badge bg-warning text-white me-2 mb-2" style="font-size: 0.7rem; padding: 0.5rem;"><i class="bi bi-cash"></i> @currency($event->event_price)</span>
                                @else
                                    <span class="badge bg-info text-white me-2 mb-2" style="font-size: 0.7rem; padding: 0.5rem;"><i class="bi bi-gift"></i> Gratis</span>
                                @endif
                                <span class="badge bg-secondary me-2 mb-2" style="font-size: 0.7rem; padding: 0.5rem;"><i class="bi bi-globe"></i> {{ $event->organization->name }}</span>
                            </div>
                            <p class="card-text">
                                <strong class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> Tanggal:</strong> 
                                @if (date("d F Y", strtotime($event->start_date)) == date("d F Y", strtotime($event->end_date)))
                                    {{ date("d F Y", strtotime($event->start_date)) }}
                                @else
                                    {{ date("d F Y", strtotime($event->start_date)) }} - {{ date("d F Y", strtotime($event->end_date)) }}
                                @endif
                                <br>
                                <strong><i class="bi bi-clock"></i> Waktu:</strong> {{ date("H:i", strtotime($event->start_date)) }} - {{ date("H:i", strtotime($event->end_date)) }} WIB
                                <br>
                                <strong><i class="bi bi-geo-alt"></i> Tempat:</strong> {{ ucwords($event->event_venue)}}
                                <br>
                                <strong><i class="bi bi-people"></i> Kuota:</strong> {{ $event->participant_quota}}
                                @if ($event->event_speaker)
                                <br>
                                <strong><i class="bi bi-megaphone"></i> Narasumber:</strong> {{ ucwords($event->event_speaker)}}
                                @endif
                            </p>
                            <hr>
                            <h5><i class="bi bi-file-text"></i> Deskripsi</h5>
                            <p class="card-text" style="text-align: justify;">{{ $event->event_description}}</p>
                            @if ($event->participant_quota > 0 )
                                <button type="button" class="btn btn-primary mt-3" onclick="registration({{$event->id}})"><i class="bi bi-pencil-square"></i> Daftar Sekarang</button>
                            @else
                                <button type="button" class="btn btn-secondary mt-3" disabled><i class="bi bi-x-circle"></i> Kuota Penuh</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                        <h5 class="text-center py-2"><strong>- Event Terkait -</strong></h5>
                        <div class="related-events">
                            @if($relatedEvents->isEmpty())
                                <div class="text-center" style="background-color: #eeebebfa; border-radius: 15px; overflow: hidden;"">
                                    <p class="text-dark-emphasis mt-3"><strong>Belum ada event terkait.</strong></p>
                                </div>
                            @else
                                @foreach($relatedEvents as $item)
                                    <div class="d-flex mb-3">
                                        <img src="{{ asset('storage/image-events/'. $item->event_image )}}" alt="Related Event" class="img-fluid rounded me-3" style="width: 100px; height: 100px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-1"><a href="#" class="text-dark text-decoration-none">{{ ucwords($item->event_name) }}</a></h6>
                                            <p class="mb-0" style="font-size: 13px;">
                                                <span class="text-secondary"><i class="bi bi-calendar-event"></i> 
                                                    @if (date("d F Y", strtotime($item->start_date)) == date("d F Y", strtotime($item->end_date)))
                                                        {{ date("d F Y", strtotime($item->start_date)) }}
                                                    @else
                                                        {{ date("d F Y", strtotime($item->start_date)) }} - {{ date("d F Y", strtotime($item->end_date)) }}
                                                    @endif
                                                </span>
                                                <br>
                                                <span class="text-secondary"><i class="bi bi-clock"></i> {{ date("H:i", strtotime($item->start_date)) }} - {{ date("H:i", strtotime($item->end_date)) }} WIB</span>
                                                <br>
                                                <span class="text-secondary">
                                                    @if ($item->method_type == 'paid')
                                                        <i class="bi bi-cash"></i> @currency($item->event_price)
                                                    @else
                                                    <i class="bi bi-gift"></i> Gratis
                                                    @endif
                                                </span>
                                            </p>
                                            <a href="{{ route('detailEvent', $item->id) }}" class="btn btn-outline-primary btn-sm mt-1">Lihat Detail</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
    </section>

@endsection

{{-- Modal --}}
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="border-radius: 15px; overflow: hidden;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="page" class="p-2"></div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        function registration(id) {
            $.get("{{ url('registration') }}/" + id, {}, function(data, status) {
                $("#staticBackdropLabel").html('Pendaftaran');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Create 
        function prosesRegistration() {
            event.preventDefault();
            var formData = new FormData($("#form-registration")[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('process-registration')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 200) {
                        $(".btn-close").click();
                        window.location.reload();
                    } else if (response.status === 400) {
                        $("input, select, textarea").removeClass('is-invalid');
                        $.each(response.errors, function(key, value) {
                            $("#" + key).addClass('is-invalid');
                            $("#" + key + "Feedback").text(value[0]);
                        });
                    }
                }
            });
        }

    </script>
@endpush

