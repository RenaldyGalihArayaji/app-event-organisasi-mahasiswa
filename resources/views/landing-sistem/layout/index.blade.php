<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  @php
        $setting = DB::table('settings')->where('id',1)->first();
  @endphp
  <title>{{ ucwords($setting->app_name)}} | {{ $title }}</title>

  <!-- Favicons -->
  <link rel="shortcut icon" href="{{ asset('storage/image_settings/' . $setting->app_logo) }}" type="image/x-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('landing-sistem/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('landing-sistem/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('landing-sistem/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('landing-sistem/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('landing-sistem/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('landing-sistem/assets/css/main.css')}}" rel="stylesheet">

</head>

<body class="index-page">

    {{-- Header --}}
        @include('landing-sistem.layout.header')
    {{-- End Header --}}

  <main class="main">

   @yield('content')

  </main>

    {{-- Footer --}}
        @include('landing-sistem.layout.footer')
    {{-- End Footer --}}
  
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>

   {{-- Sweetalaert --}}
   @include('sweetalert::alert')
   
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Vendor JS Files -->
  <script src="{{ asset('landing-sistem/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('landing-sistem/assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset('landing-sistem/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('landing-sistem/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('landing-sistem/assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
  <script src="{{ asset('landing-sistem/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{ asset('landing-sistem/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{ asset('landing-sistem/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{ asset('landing-sistem/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('landing-sistem/assets/js/main.js')}}"></script>

  @stack('scripts')

</body>

</html>