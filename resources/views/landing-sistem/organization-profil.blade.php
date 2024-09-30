@extends('landing-sistem.layout.index')

@section('content')

    <div class="page-title" data-aos="fade">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Profil Organisasi | <span class="text-secondary fs-6">{{ ucwords($organization->name)}}</span></h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home')}}" class="text-dark">Beranda</a></li>
                    <li><a href="{{ route('landingOrganization')}}" class="text-dark">Organisasi El Rahma</a></li>
                    <li class="current text-primary">Profil Organisasi</li>
                </ol>
            </nav>
        </div>
    </div>

    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Profil</h2>
            <p><span>Profil</span> <span class="description-title">Organisasi</span></p>
        </div>
        <div class="container">
            <div class="row gy-4 mb-5">
                <div class="col-lg-6 d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 w-100 border" style="border-radius: 15px; overflow: hidden;">
                        <img src="{{ asset('storage/image-organizations/'. $organization->logo) }}" class="img-fluid rounded p-5 services-img" alt="{{ $organization->name }}">
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="services-list shadow p-5">
                        <h3 class="text-center"><strong>-{{ ucwords($organization->name)}}-</strong></h3>
                        @if ($organization->description == '')
                            <p style="text-align: justify;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur excepturi, iure fugit porro eos et perferendis, quam tempore consectetur sunt nam repellat, laudantium reprehenderit ut quidem laboriosam magni labore? Ipsa facere at ut aspernatur accusamus pariatur ullam provident quis rerum dolore assumenda, eius obcaecati. Ipsum dicta quos id quasi tempore!</p>
                        @else
                            <p style="text-align: justify;">{{ ucwords($organization->description)}}</p>
                        @endif
                    </div>
                </div>
            </div>
            <hr class="w-100">
            <div class="row">
                <div class="container section-title" data-aos="fade-up">
                    <p><span>Struktur</span> <span class="description-title">Organisasi</span></p>
                </div>
                <div class="col-md-12">
                    <div class="text-center">
                        <img src="{{ asset('storage/image-organizations/'. $organization->structure_image) }}" alt="{{ $organization->name}}" class="img-fluid w-50">
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection