@extends('landing-sistem.layout.index')

@section('content')
    @php
        $setting = DB::table('settings')->where('id',1)->first();
    @endphp

    <!-- Hero Section -->
    <section id="hero" class="hero section" style="background: url('{{ asset('storage/image_settings/'. $setting->hero_image)}}') top left, rgba(8, 8, 8, 0.5);background-size: cover; background-position: center;">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-12 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                <h1 class="text-center">{{ ucwords($setting->hero_name)}} <span>{{ ucwords($setting->app_name)}}</span></h1>
                <p>{{ ucwords($setting->short_description)}}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- /Hero Section -->
  
    <!-- Stats Section -->
    <section id="stats" class="stats section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-2">
                <div class="col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-calendar4-event"></i>
                    <div class="stats-item">
                        <a href="{{ route('eventAll')}}" class="text-dark">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $eventCount}}" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Event</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-globe"></i>
                    <div class="stats-item">
                        <a href="{{ route('landingOrganization')}}" class="text-dark">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $organizationCount}}" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Organisasi</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Stats Section -->
  
    <!-- Event Section -->
    <section id="team" class="team section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Event</h2>
            <p><span>Event&nbsp;</span> <span class="description-title">Terbaru</span></p>
        </div>
  
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-md-end gap-2 mb-4">
                            <form method="GET" action="{{ route('home') }}" class="d-flex w-100">
                                <select class="form-select me-2" aria-label="Filter Kategori" name="category" onchange="this.form.submit()">
                                    <option value="">Filter Kategori</option>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>{{ ucwords($name) }}</option>
                                    @endforeach
                                </select>
                            </form>
                            <form method="GET" action="{{ route('home') }}" class="d-flex w-100">
                                <select class="form-select" aria-label="Filter Organisasi" name="organization" onchange="this.form.submit()">
                                    <option value="">Filter Organisasi</option>
                                    @foreach ($organizations as $id => $name)
                                        <option value="{{ $id }}" {{ request('organization') == $id ? 'selected' : '' }}>{{ ucwords($name) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div> 
                        <div class="col-md-12 mb-3">
                            <div class="row gy-4">
                                @if($events->isEmpty())
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <img src="{{ asset('landing-sistem/assets/img/info.png') }}" alt="No Data" style="height: 500px;" class="img-fluid">
                                        </div>
                                    </div>
                                @else
                                    @foreach ($events as $item)
                                        <div class="col-md-4 d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                                            <a href="{{ route('detailEvent', $item->id)}}" class="text-dark text-decoration-none">
                                                <div class="card shadow border-0 h-100" style="border-radius: 15px; overflow: hidden;">
                                                    <img src="{{ asset('storage/image-events/'. $item->event_image )}}" class="img-fluid p-3" alt="{{ $item->event_name }}">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><strong>{{ ucwords($item->event_name) }}</strong></h5>
                                                        <p class="card-text" style="font-size: 15px">
                                                            @if (date("d F Y", strtotime($item->start_date)) == date("d F Y", strtotime($item->end_date)))
                                                                <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y ", strtotime($item->start_date)) }}</span> <br>
                                                                <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - {{ date("H:i", strtotime($item->end_date)) }} WIB</span>
                                                            @else
                                                                <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y", strtotime($item->start_date)) }} - {{ date("d F Y", strtotime($item->end_date)) }}</span> <br>
                                                                <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - {{ date("H:i", strtotime($item->end_date)) }} WIB</span>
                                                            @endif
                                                            <br>
                                                            <strong>
                                                                @if ($item->method_type == 'paid')
                                                                    @currency($item->event_price)
                                                                @else
                                                                    Gratis
                                                                @endif
                                                            </strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                        <h5 class="text-center py-2"><strong>- Event Sedang Berlangsung -</strong></h5>
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
                                            <a href="{{ route('detailEvent', $item->id) }}" class="text-dark text-decoration-none">
                                                <h6 class="mb-1"><strong>{{ ucwords($item->event_name) }}</strong></h6>
                                                <p class="mb-0" style="font-size: 13px">
                                                    @if (date("d F Y", strtotime($item->start_date)) == date("d F Y", strtotime($item->end_date)))
                                                        <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y ", strtotime($item->start_date)) }}</span><br>
                                                        <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - {{ date("H:i", strtotime($item->end_date)) }} WIB</span>
                                                    @else
                                                        <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y", strtotime($item->start_date)) }} - {{ date("d F Y", strtotime($item->end_date)) }}</span><br>
                                                        <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - {{ date("H:i", strtotime($item->end_date)) }} WIB</span>
                                                    @endif
                                                    <br>
                                                    <span class="text-secondary-emphasis">
                                                        @if ($item->method_type == 'paid')
                                                            <i class="bi bi-cash"></i> @currency($item->event_price)
                                                        @else
                                                        <i class="bi bi-gift"></i> Gratis
                                                        @endif
                                                    </span>
                                                </p>
                                                <a href="{{ route('detailEvent', $item->id) }}" class="btn btn-outline-primary btn-sm mt-1">Lihat Detail</a>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                                @if (count($ongoingEvent) > 3)
                                    <div class="text-center mt-5">
                                        <a href="{{ route('ongoingEvent') }}" class="btn btn-primary btn-sm">Lihat Semua Event Akan Datang</a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="card p-3 mt-3 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                        <h5 class="text-center py-2"><strong>- Event Terdekat -</strong></h5>
                        <div class="p-3">
                            @if($upcomingEvent->isEmpty())
                                <div class="text-center" style="background-color: #eeebebfa; border-radius: 15px; overflow: hidden;"">
                                    <p class="text-dark-emphasis mt-3"><strong>Belum ada event.</strong></p>
                                </div>
                            @else
                                @foreach ($upcomingEvent as $item)
                                    <div class="row mb-3" data-aos="fade-up" data-aos-delay="100">
                                        <div class="col-4">
                                            <img src="{{ asset('storage/image-events/'. $item->event_image) }}" class="img-fluid rounded" alt="{{ $item->event_name }}" style="height: 100px; width: 20vh; object-fit: cover;">
                                        </div>
                                        <div class="col-8">
                                            <a href="{{ route('detailEvent', $item->id) }}" class="text-dark text-decoration-none">
                                                <h6 class="mb-1"><strong>{{ ucwords($item->event_name) }}</strong></h6>
                                                <p class="mb-0" style="font-size: 13px">
                                                    @if (date("d F Y", strtotime($item->start_date)) == date("d F Y", strtotime($item->end_date)))
                                                        <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y ", strtotime($item->start_date)) }}</span><br>
                                                        <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - {{ date("H:i", strtotime($item->end_date)) }} WIB</span>
                                                    @else
                                                        <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y", strtotime($item->start_date)) }} - {{ date("d F Y", strtotime($item->end_date)) }}</span><br>
                                                        <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - {{ date("H:i", strtotime($item->end_date)) }} WIB</span>
                                                    @endif
                                                    <br>
                                                    <span class="text-secondary-emphasis">
                                                        @if ($item->method_type == 'paid')
                                                            <i class="bi bi-cash"></i> @currency($item->event_price)
                                                        @else
                                                        <i class="bi bi-gift"></i> Gratis
                                                        @endif
                                                    </span>
                                                </p>
                                                <a href="{{ route('detailEvent', $item->id) }}" class="btn btn-outline-primary btn-sm mt-1">Lihat Detail</a>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                                @if (count($upcomingEvent) > 3)
                                    <div class="text-center mt-5">
                                        <a href="{{ route('upcomingEvent') }}" class="btn btn-primary btn-sm">Lihat Semua Event Akan Datang</a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                
                    <div class="card p-3 mt-3 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                        <h5 class="text-center py-2"><strong>- Event Sudah Berlangsung -</strong></h5>
                        <div class="p-3">
                            @if($pastEvent->isEmpty())
                                <div class="text-center" style="background-color: #eeebebfa; border-radius: 15px; overflow: hidden;"">
                                    <p class="text-dark-emphasis mt-3"><strong>Belum ada event.</strong></p>
                                </div>
                            @else
                                @foreach ($pastEvent as $item)
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
                                            <a href="{{ route('detailDocumentation', $item->id)}}" class="btn btn-outline-primary btn-sm mt-1">Dokumentasi</a>
                                        </div>
                                    </div>
                                @endforeach
                                @if (count($pastEvent) > 3)
                                    <div class="text-center mt-5">
                                        <a href="{{ route('pastEvent') }}" class="btn btn-primary btn-sm">Lihat Semua Event yang Sudah Berlangsung</a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!-- /Event Section -->
    
@endsection
