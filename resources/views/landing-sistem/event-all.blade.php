@extends('landing-sistem.layout.index')

@section('content')

    <div class="page-title" data-aos="fade">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Semua Event</h1>
            <nav class="breadcrumbs">
                <ol>
                <li><a href="{{ route('home')}}" class="text-dark">Beranda</a></li>
                <li class="current text-primary">Event</li>
                </ol>
            </nav>
        </div>
    </div>
  
    <section id="team" class="team section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Event</h2>
            <p><span>Semua</span> <span class="description-title">Event</span></p>
        </div>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <form class="d-flex" role="search" method="GET" action="{{ route('eventAll') }}">
                                <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}">
                                <button class="btn btn-outline-primary" type="submit">Search</button>
                            </form>
                        </div>
                        <div class="col-md-3 mb-3">
                            <form method="GET" action="{{ route('eventAll') }}" class="d-flex">
                                <select class="form-select me-2" aria-label="Filter Event" name="event_status" onchange="this.form.submit()">
                                    <option value="">Filter Event</option>
                                    <option value="ongoing" {{ request('event_status') == 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                                    <option value="upcoming" {{ request('event_status') == 'upcoming' ? 'selected' : '' }}>Terdekat</option>
                                    <option value="past" {{ request('event_status') == 'past' ? 'selected' : '' }}>Sudah Berlangsung</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-2 mb-3">
                            <form method="GET" action="{{ route('eventAll') }}" class="d-flex">
                                <select class="form-select me-2" aria-label="Filter Kategori" name="category" onchange="this.form.submit()">
                                    <option value="">Filter Kategori</option>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>{{ ucwords($name) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="col-md-2 mb-3">
                            <form method="GET" action="{{ route('eventAll') }}" class="d-flex">
                                <select class="form-select" aria-label="Filter Organisasi" name="organization" onchange="this.form.submit()">
                                    <option value="">Filter Organisasi</option>
                                    @foreach ($organizations as $id => $name)
                                        <option value="{{ $id }}" {{ request('organization') == $id ? 'selected' : '' }}>{{ ucwords($name) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>                                            
                    </div>
                    <div class="col-md-12 my-3">
                        <div class="row gy-4">
                            @if($events->isEmpty())
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <img src="{{ asset('landing-sistem/assets/img/info.png') }}" alt="No Data" style="height: 500px;" class="img-fluid">
                                    </div>
                                </div>
                            @else
                                @foreach ($events as $item)
                                    <div class="col-md-3 d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                                        <div class="card shadow h-100 border-0" style="border-radius: 15px; overflow: hidden;">
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
                                                @if ($item->end_date < now())
                                                    <a href="{{ route('detailDocumentation', $item->id) }}" class="btn btn-outline-primary w-100 mt-3">Dokumentasi</a>
                                                @else
                                                    <a href="{{ route('detailEvent', $item->id) }}" class="btn btn-outline-primary w-100 mt-3">Lihat Detail</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
