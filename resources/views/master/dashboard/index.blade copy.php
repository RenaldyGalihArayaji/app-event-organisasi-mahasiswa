@extends('master.layout.index')

@section('content')

<div class="main-content">
  <div class="title">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-xl-3 col-md-6 ">
        <div class="card border-0  h-100 py-3" style="border-radius: 15px; overflow: hidden;">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs text-primary mb-2 "><strong>Event Aktif</strong></div>
                <div class="fs-4 mb-0 font-weight-bold text-gray-800">{{ $eventActive}}</div>
              </div>
              <div class="col-auto">
                <i class="ti-calendar fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      @can('view event')
      {{-- Event --}}
      <div class="col-xl-3 col-md-6 ">
        <div class="card border-left-primary  h-100 py-3">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary  mb-2"><strong>Event Non-Aktif</strong></div>
                <div class="fs-4 mb-0 font-weight-bold text-gray-800">{{ $eventInactive}}</div>
              </div>
              <div class="col-auto">
                <i class="ti-calendar fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- Pengajuan Event --}}
      <div class="col-xl-3 col-md-6 ">
        <div class="card border-left-primary  h-100 py-3">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary  mb-2"><strong>Event Diajukan</strong></div>
                <div class="fs-4 mb-0 font-weight-bold text-gray-800">{{ $submissionEvent_waiting }}</div>
              </div>
              <div class="col-auto">
                <i class="ti-receipt fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 ">
        <div class="card border-left-primary  h-100 py-3">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary  mb-2"><strong>Event Ditolak</strong></div>
                <div class="fs-4 mb-0 font-weight-bold text-gray-800">{{ $submissionEvent_rejected }}</div>
              </div>
              <div class="col-auto">
                <i class="ti-receipt fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 ">
        <div class="card border-left-primary  h-100 py-3">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary  mb-2"><strong>Event Diterima</strong></div>
                <div class="fs-4 mb-0 font-weight-bold text-gray-800">{{ $submissionEvent_approved }}</div>
              </div>
              <div class="col-auto">
                <i class="ti-receipt fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endcan

      @can('view report')
      {{-- Pengajuan Laporan --}}
      <div class="col-xl-3 col-md-6 ">
        <div class="card border-left-primary  h-100 py-3">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary  mb-2"><strong>Laporan Diajukan</strong></div>
                <div class="fs-4 mb-0 font-weight-bold text-gray-800">{{ $report_waiting }}</div>
              </div>
              <div class="col-auto">
                <i class=" ti-zip fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 ">
        <div class="card border-left-primary  h-100 py-3">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary  mb-2"><strong>Laporan Ditolak</strong></div>
                <div class="fs-4 mb-0 font-weight-bold text-gray-800">{{ $report_rejected }}</div>
              </div>
              <div class="col-auto">
                <i class=" ti-zip fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 ">
        <div class="card border-left-primary  h-100 py-3">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary  mb-2"><strong>Laporan Diterima</strong></div>
                <div class="fs-4 mb-0 font-weight-bold text-gray-800">{{ $report_approved }}</div>
              </div>
              <div class="col-auto">
                <i class=" ti-zip fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endcan

      @can('view sponsorship')
      {{-- Sponsorship --}}
      @php
      $amount = 0;
      $sponsorships = \App\Models\Sponsorship::where('user_id', Auth::user()->id)->get();
      foreach ($sponsorships as $sponsorship) {
      $amount += $sponsorship->amount;
      }
      @endphp

      <div class="col-xl-3 col-md-6">
        <div class="card border-left-primary h-100 py-3">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary mb-2"><strong>Dana Sponsor</strong></div>
                <div class="fs-4 mb-0 font-weight-bold text-gray-800">@currency($amount)</div>
              </div>
              <div class="col-auto">
                <i class="ti-money fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endcan
    </div>

  </div>
</div>

@endsection