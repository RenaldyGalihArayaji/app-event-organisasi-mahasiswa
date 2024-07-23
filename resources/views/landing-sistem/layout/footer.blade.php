@php
  $setting = DB::table('settings')->where('id',1)->first();
@endphp
<footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-6 footer-about">
          <a href="index.html" class="d-flex align-items-center">
            <span class="sitename">{{ ucwords($setting->app_name)}}</span>
          </a>
          <div class="footer-contact pt-3">
            <p>{{ ucwords($setting->contact_address)}}</p>
            <p class="mt-3"><strong>Phone:</strong> <span>{{ $setting->contact_phone}}</span></p>
            <p><strong>Email:</strong> <span>{{ $setting->contact_email}}</span></p>
          </div>
        </div>

        <div class="col-lg-3 col-md-3 footer-links">
          <h4>Organisasi</h4>
          @php
              $organisasi = \App\Models\Organization::where('name','!=','super admin')->get();
          @endphp
          <ul>
            @foreach ($organisasi as $item)
                <li><a href="{{ route('organizationProfil', $item->id)}}">{{ ucwords($item->name) }}</a></li>
            @endforeach
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Menu</h4>
          <ul>
            <li><a href="{{ route('home')}}">Beranda</a></li>
            <li><a href="{{ route('eventAll')}}">Event</a></li>
            <li><a href="{{ route('about')}}">Tentang Kami</a></li>
            <li><a href="{{ route('landingCalendar')}}">Kalender</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-12">
          <h4>Sosial Media</h4>
          <div class="social-links d-flex">
            <a href="{{ $setting->youtube_url}}"><i class="bi bi-youtube"></i></a>
            <a href="{{ $setting->facebook_url}}"><i class="bi bi-facebook"></i></a>
            <a href="{{ $setting->instagram_url}}"><i class="bi bi-instagram"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">{{ ucwords($setting->app_name)}}</strong> <span>All Rights Reserved</span></p>
    </div>

  </footer>
