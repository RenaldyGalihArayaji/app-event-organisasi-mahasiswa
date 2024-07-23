<header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <a href="https://www.elrahmajogja.net/" class="text-white d-flex align-items-center">STMIK El Rahma Yogyakarta</a>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+62 811-2929-757</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="https://web.facebook.com/elrahmajogja.jogjakarta.9?_rdc=1&_rdr" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/elrahmajogja/" class="instagram"><i class="bi bi-instagram"></i></a>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-cente">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="{{ route('home')}}" class="logo d-flex align-items-center">
          <h1 class="sitename">APP MEOM</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="{{ route('home')}}" class="{{ request()->route()->getName() == 'home' ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('eventAll')}} " class="{{ request()->route()->getName() == 'eventAll' ? 'active' : '' }}">Event</a></li>
            <li><a href="{{ route('about')}} " class="{{ request()->route()->getName() == 'about' ? 'active' : '' }}">Tentang</a></li>
            <li><a href="{{ route('landingCalendar')}}" class="{{ request()->route()->getName() == 'landingCalendar' ? 'active' : '' }}">Kalender</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        

      </div>

    </div>

  </header>
