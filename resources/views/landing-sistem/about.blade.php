@extends('landing-sistem.layout.index')

@section('content')

    <div class="page-title" data-aos="fade">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Tentang Kami</h1>
            <nav class="breadcrumbs">
                <ol>
                <li><a href="{{ route('home')}}" class="text-dark">Beranda</a></li>
                <li class="current text-primary">Tentang Kami</li>
                </ol>
            </nav>
        </div>
    </div>

    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Info</h2>
            <p><span>Tentang</span> <span class="description-title">Kami</span></p>
        </div>
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <img src="{{ asset('landing-sistem/assets/img/about.png')}}" alt="" class="img-fluid services-img">
                </div>


                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="services-list py-5">
                        <h3>Aplikasi Manajemen Event Organisasi Mahasiswa <strong>STMIK El Rahma Yogyakarta</strong></h3>
                        <p style="text-align: justify;">Kami adalah Aplikasi Manajemen Event yang dirancang khusus untuk organisasi mahasiswa STMIK El Rahma Yogyakarta. Dengan fitur-fitur canggih dan antarmuka yang ramah pengguna, aplikasi kami memudahkan Anda dalam merencanakan, mengatur, dan mengelola acara secara efisien dan profesional. Kami hadir untuk mendukung aktivitas organisasi Anda, memastikan setiap acara berjalan lancar dan sukses. Aplikasi kami membantu mengoptimalkan koordinasi, komunikasi, dan administrasi, sehingga Anda dapat fokus pada hal-hal yang lebih penting dalam mencapai tujuan organisasi. Berikut adalah organisasi-organisasi yang ada di kampus STMIK El Rahma Yogyakarta.
                        </p>
                        <ul>
                            @foreach ($organization as $item)
                                <li class="list-inline"><i class="bi bi-check-circle"></i> <span>{{ ucwords($item->name) }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection