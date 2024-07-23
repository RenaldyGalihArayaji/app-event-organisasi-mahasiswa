<form id="form-role">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label" style=" font-weight: bold">Nama</label>
                <input type="text" class="form-control" id="name" name="name"  value="{{ $role->name}}">
                <div id="nameFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <table class="table table-bordered" style="width: 100%">
        <thead class="thead-light">
            <tr>
                <th style="border: 1px solid #dee2e6;vertical-align: middle; text-align: center;">Menu</th>
                <th style="border: 1px solid #dee2e6;vertical-align: middle; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menus as $menu => $actions)
                <tr>
                    <td style="padding: 0.75rem ;width: 20%">
                        @if ($menu == 'dashboard')
                            <strong>Dashboard</strong>
                        @elseif ($menu == 'role')
                            <strong>Kelola Role</strong>
                        @elseif ($menu == 'user')
                            <strong>Kelola User</strong>
                        @elseif ($menu == 'category')
                            <strong>Kategori Event</strong>
                        @elseif ($menu == 'event')
                            <strong>Pengajuan Event</strong>
                        @elseif ($menu == 'report')
                            <strong>Laporan Event</strong>
                        @elseif ($menu == 'calendar')
                            <strong>Kalender Event</strong>
                        @elseif ($menu == 'participant')
                            <strong>Data Peserta</strong>
                        @elseif ($menu == 'sponsorship')
                            <strong>Kelola Sponsorship</strong>
                        @elseif ($menu == 'organization')
                            <strong>Kelola Organisasi</strong>
                        @elseif ($menu == 'setting')
                            <strong>Pengaturan</strong>
                        @endif
                    </td>
                    <td>
                        @foreach ($actions as $action)
                            <div class="form-check form-switch d-inline-block" style="margin-bottom: 0.5rem">
                                <input class="form-check-input" type="checkbox" id="{{ $menu }}-{{ $action }}" name="permissions[]" value="{{ $action }} {{ $menu }}" {{ in_array($permissions->firstWhere('name', "$action $menu")->id, $rolePermission) ? 'checked' : '' }}>
                                <label class="form-check-label" style="margin-left: 0.3rem" for="{{ $menu }}-{{ $action }}">
                                    {{ ucfirst($action) }}
                                </label>
                            </div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <button type="submit" class="btn btn-primary mb-3" onclick="update({{$role->id}})">Update</button>
</form>