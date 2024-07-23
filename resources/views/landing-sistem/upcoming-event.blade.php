@extends('landing-sistem.layout.index')

@section('content')

    <div class="page-title" data-aos="fade">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Event | <span class="text-secondary fs-6">Terdekat</span></h1>
            <nav class="breadcrumbs">
                <ol>
                <li><a href="{{ route('home')}}" class="text-dark">Beranda</a></li>
                <li class="current text-primary">Event Terdekat</li>
                </ol>
            </nav>
        </div>
    </div>
  
    <section id="team" class="team section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Event</h2>
            <p><span>Event</span> <span class="description-title">Terdekat</span></p>
        </div>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-7 mb-3 mb-md-0">
                            <form class="d-flex" role="search" method="GET" action="{{ route('upcomingEvent') }}">
                                <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}">
                                <button class="btn btn-outline-primary" type="submit">Search</button>
                            </form>
                        </div>
                        <div class="col-md-5 d-flex justify-content-md-end gap-2">
                            <form method="GET" action="{{ route('upcomingEvent') }}" class="d-flex">
                                <select class="form-select me-2" aria-label="Filter Kategori" name="category" onchange="this.form.submit()">
                                    <option value="">Filter Kategori</option>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>{{ ucwords($name) }}</option>
                                    @endforeach
                                </select>
                            </form>
                            <form method="GET" action="{{ route('upcomingEvent') }}" class="d-flex">
                                <select class="form-select" aria-label="Filter Organisasi" name="organization" onchange="this.form.submit()">
                                    <option value="">Filter Organisasi</option>
                                    @foreach ($organizations as $id => $name)
                                        <option value="{{ $id }}" {{ request('organization') == $id ? 'selected' : '' }}>{{ ucwords($name) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>                                              
                        <div class="col-md-12 my-3">
                            <!-- Cards Section -->
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
                                                    <img src="{{ asset('storage/image-events/'. $item->event_image )}}" class="img-fluid rounded p-3" alt="{{ $item->event_name }}">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><strong>{{ ucwords($item->event_name) }}</strong></h5>
                                                        <p class="card-text" style="font-size: 15px">
                                                            @if (date("d F Y", strtotime($item->start_date)) == date("d F Y", strtotime($item->end_date)))
                                                            <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y ", strtotime($item->start_date)) }}</span> <br>
                                                            <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - Selesai WIB</span>
                                                            @else
                                                            <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y", strtotime($item->start_date)) }} - {{ date("d F Y", strtotime($item->end_date)) }}</span> <br>
                                                            <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - Selesai WIB</span>
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
                                                        <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - Selesai WIB</span>
                                                    @else
                                                        <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y", strtotime($item->start_date)) }} - {{ date("d F Y", strtotime($item->end_date)) }}</span><br>
                                                        <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - Selesai WIB</span>
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
                                @if (count($ongoingEvent) > 5)
                                    <div class="text-center mt-5">
                                        <a href="{{ route('ongoingEvent') }}" class="btn btn-primary btn-sm">Lihat Semua Event yang Sudah Berlangsung</a>
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
                                                    <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - Selesai WIB</span>
                                                @else
                                                    <span class="text-secondary-emphasis"><i class="bi bi-calendar-event"></i> {{ date("d F Y", strtotime($item->start_date)) }} - {{ date("d F Y", strtotime($item->end_date)) }}</span><br>
                                                    <span class="text-secondary-emphasis"><i class="bi bi-alarm"></i> {{ date("H:i", strtotime($item->start_date)) }} - Selesai WIB</span>
                                                @endif
                                            </p>
                                            <a href="{{ route('detailDocumentation', $item->id)}}" class="btn btn-outline-primary btn-sm mt-1">Dokumentasi</a>
                                        </div>
                                    </div>
                                @endforeach
                                @if (count($pastEvent) > 5)
                                    <div class="text-center mt-5">
                                        <a href="{{ route('pastEvent') }}" class="btn btn-primary btn-sm">Lihat Semua Event Akan Datang</a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    {{ $events->links()}}
                </div>
            </div>
        </div>
        
        
    </section>

@endsection