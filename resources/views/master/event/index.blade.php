@extends('master.layout.index')

@section('content')
    
<div class="main-content">
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Komponen | <span class="text-secondary fs-5">Pengajuan Event</span></h1>
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Pengajuan Event</h4>
                    </div>
                    <div class="card-body">
                        @can('create event')
                            <button class="btn mb-3 icon-left btn-primary btn-sm" onclick="create()">
                                <i class="ti-plus"></i>Tambah Data
                            </button>
                        @endcan
                        <table id="example2" class="table dt-responsive display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Poster</th>
                                    <th>Nama Event</th>
                                    <th>Penyelenggara</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status Pengajuan</th>
                                    @if (Auth::check() && (Auth::user()->can('show event') || Auth::user()->can('update event') || Auth::user()->can('update-khusus event') || Auth::user()->can('delete event')))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($event as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset('storage/image-events/' . $item->event_image) }}" alt="" width="40">
                                        </td>
                                        <td>{{ ucwords($item->event_name) }}</td>
                                        <td>{{ ucwords($item->organization->name) }}</td>
                                        <td>{{ date('d F Y - H:i', strtotime($item->start_date)) }} WIB</td>
                                        <td >{{ date('d F Y - H:i', strtotime($item->end_date)) }} WIB</td>
                                        <td>
                                            @if ($item->submissionEvent->submission_status == 'waiting')
                                                <span>Menunggu Konfirmasi</span>
                                            @endif

                                            @if ($item->submissionEvent->submission_status == 'rejected')
                                                 <span>Pengajuan Ditolak</span>
                                             @endif

                                             @if ($item->submissionEvent->submission_status == 'approved')
                                                <span>Pengajuan Diterima/Publish</span>
                                            @endif
                                        </td>
                                        @if (Auth::check() && (Auth::user()->can('show event') || Auth::user()->can('update event') || Auth::user()->can('update-khusus event') || Auth::user()->can('delete event')))
                                            <td>

                                                @can('show event')
                                                    <button class="btn btn-warning btn-sm my-1" onclick="show({{ $item->id }})">
                                                        <i class="ti-eye"></i>
                                                    </button>
                                                @endcan

                                                @can('update event')
                                                    <button class="btn btn-success btn-sm my-1" onclick="edit({{ $item->id }})">
                                                        <i class="ti-pencil-alt"></i>
                                                    </button>
                                                @endcan

                                                @can('update-khusus event')
                                                    <button class="btn btn-success btn-sm my-1" onclick="edit_khusus({{$item->id}})"><i class="ti-pencil-alt"></i></button>   
                                                @endcan

                                                @can('delete event')
                                                    <form action="{{ route('event.destroy', $item->id) }}" method="post" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger btn-sm confirm-delete my-1">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        @endif
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

 {{-- Modal --}}
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="page" class="p-2"></div>
            </div>
        </div>
     </div>
</div>

@push('scripts')
    <script src="{{ asset('template-admin/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('template-admin/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('template-admin/vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('template-admin/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('template-admin//assets/js/pages/datatables.min.js')}}"></script>

    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        DataTable.init()
    </script>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // Tampilan Modal Create
        function create() {
            $.get("{{ route('event.create')}}", {} , function(data,status) {
                $("#staticBackdropLabel").html('Tambah Event');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        function store() {
            event.preventDefault();
            var formData = new FormData($("#form-event")[0]); 

            $.ajax({
                type: "POST",
                url: "{{ route('event.store')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 200) {
                        $(".btn-close").click();
                        window.location.reload();
                    } else if (response.status === 400) {
                        $("input, select, textarea").removeClass('is-invalid');
                        $.each(response.errors, function(key, value) {
                            $("#" + key).addClass('is-invalid');
                            $("#" + key + "Feedback").text(value[0]);
                        });
                    } else if (response.status === 409) {
                        $(".btn-close").click();
                        window.location.reload();
                    }
                }
            });
        }

        // Tampilan Modal show
        function show(id) {
            $.get("{{ url('component/event') }}/" + id, {}, function(data, status) {
                $("#staticBackdropLabel").html('Detail Event');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Tampilan Modal Edit
        function edit(id) {
            $.get("{{ url('component/event') }}/" + id + "/edit", {}, function(data, status) {
                $("#staticBackdropLabel").html('Edit Event');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Edit
        function update(id) {
            event.preventDefault();
            var formData = new FormData($("#form-event")[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('event.update', '') }}/" + id,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 200) {
                        $(".btn-close").click();
                        window.location.reload();
                    } else if (response.status === 400) {
                        $("input, select, textarea").removeClass('is-invalid');
                        $.each(response.errors, function(key, value) {
                            $("#" + key).addClass('is-invalid');
                            $("#" + key + "Feedback").text(value[0]);
                        });
                    }
                }
            });
        }

        // Tampilan Modal Edit Khusus
        function edit_khusus(id) {
            $.get("{{ url('component/event/edit-khusus') }}/" + id + "/edit", {}, function(data, status) {
                $("#staticBackdropLabel").html('Edit Event');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Edit Khusus
        function update_khusus(id) {
            event.preventDefault();
            var formData = new FormData($("#form-event-khusus")[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('update_khusus_event', '') }}/" + id,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 200) {
                        $(".btn-close").click();
                        window.location.reload();
                    } else if (response.status === 400) {
                        $("input, select, textarea").removeClass('is-invalid');
                        $.each(response.errors, function(key, value) {
                            $("#" + key).addClass('is-invalid');
                            $("#" + key + "Feedback").text(value[0]);
                        });
                    }
                }
            });
        }

        // Delete
        $('.confirm-delete').click(function(event) {

            //This will choose the closest form to the button
            var form =  $(this).closest("form");

            //don't let the form submit yet
            event.preventDefault();

            //configure sweetalert alert as you wish
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                // text: "Data Akan di Hapus",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Sukses!',
                    'Data Berhasil dihapus.',
                    'success'
                    )
                    form.submit();
                }
            })
        });


    </script>

@endpush
