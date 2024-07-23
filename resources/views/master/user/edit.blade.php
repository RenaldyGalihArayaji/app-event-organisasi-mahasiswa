<form id="form-user" method="POST" action="{{ route('user.update', $user->id) }}">
    @csrf
    @method('PUT')
    <div class="row">
        @if ($user->organization->name == 'super admin')
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                    <div id="nameFeedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                    <div id="emailFeedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="role" class="form-label">Roles</label>
                    <select class="js-example-basic-single form-select form-select-sm" id="role" name="role">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ in_array($role->id, $userRoles) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <div id="roleFeedback" class="invalid-feedback"></div>
                </div>
            </div>
        @else
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                    <div id="nameFeedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                    <div id="emailFeedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="role" class="form-label">Roles</label>
                    <select class="form-control" id="role" name="role">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ in_array($role->id, $userRoles) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <div id="roleFeedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="organization_id" class="form-label">Organisasi</label>
                    <select name="organization_id" class="form-control" id="organization_id">
                        <option value="{{ $user->organization->id }}">{{ $user->organization->name }}</option>
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                        @endforeach
                    </select>
                    <div id="organization_idFeedback" class="invalid-feedback"></div>
                </div>
            </div>
        @endif
    </div>
    <button type="submit" class="btn btn-primary mb-3">Update</button>
</form>
