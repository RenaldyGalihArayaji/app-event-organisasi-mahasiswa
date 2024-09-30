@extends('master.layout.index')

@section('content')
    
    <div class="main-content">
        <div class="title">
            <h1 class="h3 mb-0 text-gray-800">Data Peserta | <span class="text-secondary fs-5">{{ ucwords($event->event_name)}}</span></h1>
        </div>
        <div class="content-wrapper">
            <div class="row same-height">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Peserta</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn icon-left btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#scannerModal"><i class="bi bi-upc-scan me-2"></i>Scanner</button> 
                                    <a href="{{ route('exportExcel', ['id' => $event->id]) }}" class="btn btn-success btn-sm mb-2"><i class="bi bi-file-earmark-spreadsheet me-2"></i>Export Excel</a>
                                    <a href="{{ route('exportPdf', ['id' => $event->id]) }}" class="btn btn-danger btn-sm mb-2"><i class="bi bi-file-pdf me-2"></i>Export PDF</a>
                                    @if ($event->end_date < now())
                                        @if ($event->documentation == '')
                                            <button class="btn btn-warning btn-sm mb-2" onclick="documentation({{ $event->id }})">
                                                <i class="bi bi-upload me-2"></i>Upload Dokumentasi
                                            </button>
                                        @else
                                            <button class="btn btn-warning btn-sm mb-2" onclick="documentationShow({{ $event->id }})">
                                                <i class="bi bi-eye me-2"></i>Lihat Dokumentasi
                                            </button>
                                        @endif
                                    @endif
                                
                                </div>
                                <div>
                                    <a href="{{ route('participant.index')}}" class="btn mb-3 icon-left btn-secondary btn-sm mb-2 "><i class="bi bi-arrow-left-circle me-2"></i>Kembali</a> 
                                </div>
                            </div>
                            <table id="example2" class="table dt-responsive display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Peserta</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIM</th>
                                        <th>Program Studi</th>
                                        <th>Email</th>
                                        <th>Nomor Telepon</th>
                                        <th>Status</th>
                                        <th>Status Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registrations as $item)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ $item->code_registration}}</td>
                                            <td>{{ ucwords($item->name)}}</td>
                                            <td>{{ $item->nim}}</td>
                                            <td>{{ ucwords($item->prodi)}}</td>
                                            <td>{{ $item->email}}</td>
                                            <td>{{ $item->phone}}</td>
                                            <td>
                                                @if ($item->attendance_status == 'present')
                                                    <span>Hadir</span>
                                                @else
                                                    <span>Belum Hadir</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->email_status == 'waiting')
                                                    <span>Menunggu Konfirmasi</span></td>
                                                @else
                                                    <span>Email Sudah Dikirim</span></td>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        •••
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @if ($item->email_status == 'waiting')
                                                            <li>
                                                                <a href="{{ route('approveRegistration', $item->id)}}" class="dropdown-item">Konfirmasi</a>
                                                            </li>
                                                        @endif
                                            
                                                        @if ($item->proof_payment)
                                                            <li>
                                                                <button class="dropdown-item" onclick="show({{ $item->id }})">Bukti Pembayaran</button>
                                                            </li>
                                                        @endif

                                                        {{-- <li>
                                                            <button class="dropdown-item" onclick="sertifikat({{ $item->id }})">Upload Sertifikat</button>
                                                        </li> --}}
                                            
                                                        @can('delete participant')
                                                            <li>
                                                                <form action="{{ route('participant.destroy', $item->id)}}" method="post" class="d-inline">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" class="dropdown-item confirm-delete">Hapus</button>
                                                                </form>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>
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

<!-- Modal scanner -->
<div class="modal fade" id="scannerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h1 class="modal-title fs-5" id="scannerModalLabel">Scanner</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <div id="reader" width="600px"></div>
                    <input type="hidden" name="result" id="result">
                </div>
            </div>
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
    {{-- scanner --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        DataTable.init()
    </script>

    <script>

        // Tampilan Modal show
        function show(id) {
            $.get("{{ url('participant/proof_payment') }}/" + id, {}, function(data, status) {
                $("#staticBackdropLabel").html('Bukti Pembayaran');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Tampilan Modal dokumentasi
        function documentation(id) {
            $.get("{{ url('participant/documentation') }}/" + id, {}, function(data, status) {
                $("#staticBackdropLabel").html('Upload Dokumentasi');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Tampilan Show Dokumentasi
        function documentationShow(id) {
            $.get("{{ url('participant/documentation/show') }}/" + id, {}, function(data, status) {
                $("#staticBackdropLabel").html('Lihat Dokumentasi');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Upload Dokumentasi
        function uploadDocumentation(id) {
            event.preventDefault();
            var formData = new FormData($("#form-dokumentasi")[0]);

                $.ajax({
                type: "POST",
                url: "{{ route('uploadDocumentation', '') }}/" + id,
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

        // Tampilan Upload Sertifkat
        function sertifikat(id) {
            $.get("{{ url('participant/sertifikat') }}/" + id, {}, function(data, status) {
                $("#staticBackdropLabel").html('Upload Sertifikat');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Upload Sertifkat
        function uploadSertifikat(id) {
            event.preventDefault();
            var formData = new FormData($("#form-sertifikat")[0]);

                $.ajax({
                type: "POST",
                url: "{{ route('uploadSertifikat', '') }}/" + id,
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
                confirmButtonText: 'ya, hapus!'
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

    {{-- Scanner --}}
    <script>
    function onScanSuccess(decodedText, decodedResult) {
            $('#result').val(decodedText);
            var code = decodedText;

            html5QrcodeScanner.clear().then(() => {
                $.ajax({
                    url: "{{ route('checkRegistration')}}",
                    type: "POST",
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        qr_code: code,
                        event_id: {{ $event->id}}
                    },
                    success: function (data) {
                        $(".btn-close").click();
                        location.reload(); // Me-reload halaman setelah pemindaian berhasil
                    },
                    error:function(){
                        $(".btn-close").click();
                        location.reload(); // Me-reload halaman setelah pemindaian berhasil
                    }
                });
            });
        }   


        function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        // console.warn(`Code scan error = ${error}`);
        }


        let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 300, height: 300} },
        /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>

    </script>

@endpush
