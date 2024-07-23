@extends('master.layout.index')

@section('content')
    
    <div class="main-content">
        <div class="title">
            <h1 class="h3 mb-0 text-gray-800">Konfigurasi | <span class="text-secondary fs-5">User</span></h1>
        </div>
        <div class="content-wrapper">
            <div class="row same-height">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel User</h4>
                        </div>
                        <div class="card-body">

                            @can('create user')
                            <button  class="btn mb-3 icon-left btn-primary btn-sm" onclick="create()"><i class="ti-plus"></i>Tambah Data</button>    
                            @endcan

                            <table id="example2" class="table dt-responsive display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Organisasi</th>

                                        @if (Auth::check() && Auth::user()->can('update user') || Auth::user()->can('delete user'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ ucwords($item->name) }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                @if (!empty($item->getRoleNames()))
                                                    @foreach ($item->getRoleNames() as $role)
                                                        <span>{{ ucwords($role) }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->organization->name == 'super admin')
                                                    <strong>-</strong>
                                                @else
                                                    <span>{{ ucwords($item->organization->name) }}</span>
                                                @endif
                                            </td>

                                            @if (Auth::check() && Auth::user()->can('update user') || Auth::user()->can('delete user'))    
                                            <td>
                                                
                                                @can('update user')
                                                <button class="btn btn-success btn-sm" onclick="edit({{$item->id}})"><i class="ti-pencil-alt"></i></button>    
                                                @endcan
                                                
                                                @can('delete user')
                                                <form action="{{ route('user.destroy', $item->id)}}" method="post" class="d-inline" >
                                                    @csrf
                                                    @method( 'delete' )
                                                    <button type="submit" class="btn btn-danger btn-sm confirm-delete"><i class="ti-trash"></i></button>
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

@endsection

@push('scripts')
<script src="{{ asset('template-admin/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('template-admin/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{ asset('template-admin/vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('template-admin/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
<script src="{{ asset('template-admin//assets/js/pages/datatables.min.js')}}"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    DataTable.init()
</script>

<script>

   // Tampilan Modal Create
   function create() {
        $.get("{{ route('user.create') }}", {}, function(data, status) {
            $("#staticBackdropLabel").html('Tambah User');
            $("#page").html(data);
            $("#staticBackdrop").modal("show");
        });
    }

    function store() {
        event.preventDefault(); // Mencegah form submit default
        var dataToForm = $("#form-user").serialize(); //Mengambil data di dalam form

        $.ajax({
            type: "POST",
            url: "{{ route('user.store') }}", // Menggunakan route name
            data: dataToForm,
            success: function(response) {
                if (response.status === 200) {
                    $(".btn-close").click(); // Menutup modal setelah alert ditutup
                    window.location.reload();
                } else if (response.status === 400) {
                    // Menghapus kelas is-invalid jika tidak ada kesalahan
                    $("input, select").removeClass('is-invalid');

                    // Menampilkan pesan kesalahan spesifik
                    $.each(response.errors, function(key, value) {
                        $("#" + key).addClass('is-invalid');
                        $("#" + key + "Feedback").text(value[0]);
                    });
                }
            }
        });
    }

    // Tampilan Modal Eidt
    function edit(id) {
        $.get("{{ url('configuration/user') }}/" + id + "/edit", {}, function(data, status) {
            $("#staticBackdropLabel").html('Edit User');
            $("#page").html(data);
            $("#staticBackdrop").modal("show");
        });
    }

     // Proses Edit 
     function update(id) {
        event.preventDefault(); // Mencegah form submit default
        var dataToForm = $("#form-user").serialize(); //Mengambil data di dalam form

        $.ajax({
            type: "PUT",
            url: "{{ route('user.update', '') }}/" + id,
            data: dataToForm,
            success: function(response) {
                if (response.status === 200) {
                    $(".btn-close").click(); // Menutup modal setelah alert ditutup
                    window.location.reload();
                } else if (response.status === 400) {
                    // Menghapus kelas is-invalid jika tidak ada kesalahan
                    $("input, select").removeClass('is-invalid');

                    // Menampilkan pesan kesalahan spesifik
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
            title: 'Apakah Kamu Yakin?',
            // text: "Data Akan di Hapus",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Sukses',
                'Data Berhasil dihapus.',
                'success'
                )
                form.submit();
            }
        })
    });


</script>
@endpush