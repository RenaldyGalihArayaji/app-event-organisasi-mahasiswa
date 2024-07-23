@extends('master.layout.index')

@section('content')
    
    <div class="main-content">
        <div class="title">
            <h1 class="h3 mb-0 text-gray-800">Laporan| <span class="text-secondary fs-5">Event</span></h1>
        </div>
        <div class="content-wrapper">
            <div class="row same-height">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Laporan Event</h4>
                        </div>
                        <div class="card-body">
                            @can('create report')
                                <button class="btn mb-3 icon-left btn-primary btn-sm" onclick="create()"><i class="ti-plus"></i>Tambah Data</button>    
                            @endcan
                            <table id="example2" class="table dt-responsive display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Penyelenggara</th>
                                        <th>Nama Event</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Dokumen Laporan </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reportEvent as $item)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ ucwords($item->organization) }}</td>
                                            <td>{{ ucwords($item->event) }}</td>
                                            <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                            <td>
                                                <a href="{{ route('downloadReport', $item->document) }}" class="btn btn-primary btn-sm">Download <i class="ti-arrow-down"></i></a>
                                            </td>   
                                            <td>
                                                @if ($item->status == 'waiting')
                                                    <span>Menunggu Konfirmasi</span>
                                                @endif
                                                @if ($item->status == 'rejected')
                                                    <span>Pengajuan Ditolak</span>
                                                @endif
                                                @if ($item->status == 'approved')
                                                    <span>Pengajuan Diterima</span>
                                                @endif
                                            </td>
                                            <td>
                                                @can('show report')  
                                                    <button class="btn btn-warning btn-sm my-1" onclick="show({{$item->id}})"><i class="ti-eye"></i></button> 
                                                @endcan

                                                @can('update report')
                                                    <button class="btn btn-success btn-sm my-1" onclick="edit({{$item->id}})"><i class="ti-pencil-alt"></i></button>   
                                                @endcan
                                                
                                                @can('update-khusus report')
                                                <button class="btn btn-success btn-sm my-1" onclick="edit_khusus({{$item->id}})"><i class="ti-pencil-alt"></i></button>   
                                                @endcan
                                            
                                                @can('delete report')
                                                    <form action="{{ route('report.destroy', $item->id)}}" method="post" class="d-inline" >
                                                        @csrf
                                                        @method( 'delete' )
                                                        <button type="submit" class="btn btn-danger btn-sm confirm-delete my-1" ><i class="ti-trash"></i></button>
                                                    </form>  
                                                @endcan
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

 {{-- Modal --}}
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
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
            $.get("{{ route('report.create')}}", {} , function(data,status) {
                $("#staticBackdropLabel").html('Tambah Pengajuan Laporan');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Create 
        function store() {
            event.preventDefault(); // Mencegah form submit default
            var formData = new FormData($("#form-submission-report")[0]); // Mengambil data di dalam form, termasuk file
        
            $.ajax({
                type: "POST",
                url: "{{ route('report.store')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 200) {
                        $(".btn-close").click(); // Menutup modal setelah alert ditutup
                        window.location.reload();
                    } else if (response.status === 400) {
                        // Menghapus kelas is-invalid jika tidak ada kesalahan
                        $("input, select, textarea").removeClass('is-invalid');

                        // Menampilkan pesan kesalahan spesifik
                        $.each(response.errors, function(key, value) {
                            $("#" + key).addClass('is-invalid');
                            $("#" + key + "Feedback").text(value[0]);
                        });
                    }
                }
            });
        }

        // Tampilan Modal show
        function show(id) {
            $.get("{{ route('report.show', '') }}/" + id, {}, function(data, status) {
                $("#staticBackdropLabel").html('Detail Pengajuan Laporan');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Tampilan Modal Edit
        function edit(id) {
            $.get("{{ url('report') }}/" + id + "/edit", {}, function(data, status) {
                $("#staticBackdropLabel").html('Edit Pengajuan Laporan');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Update
        function update(id) {
            event.preventDefault();
            var formData = new FormData($("#form-submission-report")[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('report.update', '') }}/" + id,
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

        // Proses Delete
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
                confirmButtonText: 'ya, delete!'
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

        // Tampilan Modal Edit Khusus
        function edit_khusus(id) {
            $.get("{{ url('report/edit-khusus') }}/" + id + "/edit", {}, function(data, status) {
                $("#staticBackdropLabel").html('Edit Pengajuan Laporan');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Update Khusus
        function update_khusus(id) {
            event.preventDefault();
            var formData = new FormData($("#form-submission-report-khusus")[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('update_khusus_report', '') }}/" + id,
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
    </script>
    
@endpush
