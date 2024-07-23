@extends('landing-sistem.layout.index')

@section('content')

    <div class="page-title" data-aos="fade">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Organisasi | <span class="text-secondary fs-6">El Rahma</span></h1>
            <nav class="breadcrumbs">
                <ol>
                <li><a href="{{ route('home')}}" class="text-dark">Beranda</a></li>
                <li class="current text-primary">Organisasi El Rahma</li>
                </ol>
            </nav>
        </div>
    </div>
  
    <section id="team" class="team section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Organisasi</h2>
            <p><span>Organisasi</span> <span class="description-title">El Rahma</span></p>
        </div>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12 my-3">
                    <div class="row gy-4">
                        @if($organizations->isEmpty())
                            <div class="col-md-12">
                                <div class="text-center">
                                    <img src="{{ asset('landing-sistem/assets/img/info.png') }}" alt="No Data" style="height: 500px;" class="img-fluid">
                                </div>
                            </div>
                        @else
                            @foreach ($organizations as $item)
                                <div class="col-md-3 d-flex justify-content-center mb-4" data-aos="fade-up" data-aos-delay="100">
                                    <div class="card shadow h-100 border-0" style="border-radius: 15px; overflow: hidden;">
                                        <img src="{{ asset('storage/image-organizations/'. $item->logo) }}" class="img-fluid rounded p-3" alt="{{ $item->name }}">
                                        <div class="card-body text-center">
                                            <h5 class="card-title"><strong>{{ ucwords($item->name) }}</strong></h5>
                                            <a href="{{ route('organizationEvent', $item->id)}}" class="btn btn-outline-primary w-100 mb-2">Event</a>
                                            <a href="{{ route('organizationProfil', $item->id)}}" class="btn btn-outline-primary w-100 mb-2">Profil</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    {{ $organizations->links()}}
                </div>
            </div>
        </div>
        
        
    </section>

@endsection
