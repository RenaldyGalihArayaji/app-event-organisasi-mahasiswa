@extends('landing-sistem.layout.index')

@php
    use App\Helpers\YouTubeHelper;
@endphp


@section('content')

    <div class="page-title" data-aos="fade">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Dokumentasi | <span class="text-secondary fs-6">{{ ucwords($event->event_name)}}</span></h1>
            <nav class="breadcrumbs">
                <ol>
                <li><a href="{{ route('home')}}" class="text-dark">Beranda</a></li>
                <li class="current text-primary">Dokumentasi</li>
                </ol>
            </nav>
        </div>
    </div>


    <section id="event-details" class="event-details section ">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 mb-5">
            <div class="col-md-8">
                <div class="card mb-3 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                    @if ($event->documentation == null)
                    <div class="text-center">
                        <img src="{{ asset('landing-sistem/assets/img/info.png') }}" alt="No Data" style="height: 500px;" class="img-fluid p-3">
                    </div>
                    @else
                    @if ($event->documentation->youtube_url != '')
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="embed-responsive embed-responsive-16by9" style="height: 50vh;">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ YouTubeHelper::getYouTubeVideoId($event->documentation->youtube_url) }}" allowfullscreen style="width: 100%; height: 100%;"></iframe>
                                </div>
                            </div>
                        </div>
                    @else            
                        <img src="{{ asset('storage/image-documentations/'. $event->documentation->image )}}" alt="Event Image" class="img-fluid card-img-top" style="height: 50vh; object-fit: cover; object-position: center">
                    @endif
                    <div class="card-body" style="padding: 1.5rem;">
                        @if ($event->documentation->gDrive_url)
                          <h6>
                            <i class="bi bi-link-45deg"></i> Dokumentasi Lengkap
                              <a href="{{ $event->documentation->gDrive_url}}" class="text-decoration-none" target="_blank">Klik disini</a>
                          </h6>
                        @endif
                        <h6>
                            <i class="bi bi-file-text"></i> Deskripsi
                        </h6>
                        <p class="card-text" style="text-align: justify;">{{ $event->documentation->description}}</p>
                    </div>
                    @endif
                </div>
            </div>
    
            <div class="col-md-4">
                <div class="card p-3 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                    <h5 class="text-center py-2">
                        <strong>- {{ ucwords($event->event_name)}} -</strong>
                    </h5>
                    <img src="{{ asset('storage/image-events/'. $event->event_image )}}" alt="Event Image" class="img-fluid card-img-top" style="height: 50vh; object-fit: cover; object-position: center">
                    <div class="card-body" style="padding: 1.5rem;">
                        <p class="card-text">
                            <strong class="text-secondary-emphasis">
                                <i class="bi bi-calendar-event"></i> Tanggal:
                            </strong> 
                            @if (date("d F Y", strtotime($event->start_date)) == date("d F Y", strtotime($event->end_date)))
                                {{ date("d F Y", strtotime($event->start_date)) }}
                            @else
                                {{ date("d F Y", strtotime($event->start_date)) }} - {{ date("d F Y", strtotime($event->end_date)) }}
                            @endif
                            <br>
                            <strong>
                                <i class="bi bi-clock"></i> Waktu:
                            </strong> 
                            {{ date("H:i", strtotime($event->start_date)) }} - {{ date("H:i", strtotime($event->end_date)) }} WIB
                            <br>
                            <strong>
                                <i class="bi bi-geo-alt"></i> Tempat:
                            </strong> 
                            {{ ucwords($event->event_venue)}}
                        </p>
                        <hr>
                        <h5>
                            <i class="bi bi-file-text"></i> Deskripsi
                        </h5>
                        <p class="card-text" style="text-align: justify;">{{ $event->event_description}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
  
    </section>

@endsection

@push('script')
    <script>
         function embedVideo() {
        var url = document.getElementById('youtube-url').value;
        var videoId = getYouTubeVideoId(url);
        if (videoId) {
            var embedUrl = 'https://www.youtube.com/embed/' + videoId;
            document.getElementById('video-frame').src = embedUrl;
        } else {
            alert('Please enter a valid YouTube URL.');
        }
    }
    </script>
@endpush

