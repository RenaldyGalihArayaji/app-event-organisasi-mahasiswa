@extends('master.layout.index')

@section('content')
    
    <div class="main-content">
        <div class="title">
            <h1 class="h3 mb-0 text-gray-800">Data Peserta</h1>
        </div>
        <div class="content-wrapper">
            <div class="row same-height">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Event</h4>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table dt-responsive display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Poster</th>
                                        <th>Nama Event</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($events as $item)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>
                                                <img src="{{ asset('storage/image-events/'. $item->event_image )}}" alt="" width="40">
                                            </td>
                                            <td>{{ ucwords($item->event_name)  }}</td>
                                            <td>{{ date('d F Y H:i:s', strtotime($item->start_date )) }}</td>
                                            <td>{{ date('d F Y H:i:s', strtotime($item->end_date )) }}</td>
                                            <td>
                                                <a href="{{ route('participant.show', $item->id)}}" class="btn btn-warning btn-sm my-1">Lihat Peserta</a> 
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('template-admin/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('template-admin/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{ asset('template-admin/vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('template-admin/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
<script src="{{ asset('template-admin//assets/js/pages/datatables.min.js')}}"></script>

<script>
    DataTable.init()
</script>

@endpush
