<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $setting = DB::table('settings')->where('id',1)->first();
    @endphp

    <title>{{ ucwords($setting->app_name)}} | {{  $title }}</title>
    <link rel="shortcut icon" href="{{ asset('storage/image_settings/' . $setting->app_logo) }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
        integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
        crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('template-admin/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('template-admin/vendor/themify-icons/themify-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('template-admin/vendor/perfect-scrollbar/css/perfect-scrollbar.css')}}">

    <!-- CSS for this page only -->
    <link rel="stylesheet" href="{{ asset('template-admin/vendor/chart.js/Chart.min.css')}}">
    <!-- End CSS  -->

    <!-- CSS for this page only -->
    <link href="{{ asset('template-admin/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('template-admin/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" />

    <!-- CSS for this page only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('template-admin/assets/css/style.min.css')}}">
    <link rel="stylesheet" href="{{ asset('template-admin/assets/css/bootstrap-override.min.cs')}}s">
    <link rel="stylesheet" id="theme-color" href="{{ asset('template-admin/assets/css/dark.min.css')}}">
</head>

<body>
    <div id="app">
        <div class="shadow-header"></div>

        {{-- Header --}}
        @include('master.layout.navbar')

        {{-- Sidebar --}}
        @include('master.layout.sidebar')

        @yield('content')

        {{-- Settingan --}}
        @include('master.layout.settingan')

        <footer>
            Copyright &#169; {{ now()->year }} {{ ucwords($setting->app_name)}}<span> . All rights Reserved</span>
        </footer>
        <div class="overlay action-toggle">
        </div>
    </div>

     {{-- Sweetalaert --}}
     @include('sweetalert::alert')
     
     
     <script src="{{ asset('template-admin/vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
     <script src="{{ asset('template-admin/vendor/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
     <script src="{{ asset('template-admin/assets/js/pages/index.min.js')}}"></script>
     <script src="{{ asset('template-admin/vendor/jquery/jquery.min.js')}}"></script>

     @stack('scripts')

    <script src="{{ asset('template-admin/assets/js/main.min.js')}}"></script>
    
    <script>
        Main.init()
    </script>
</body>

</html>