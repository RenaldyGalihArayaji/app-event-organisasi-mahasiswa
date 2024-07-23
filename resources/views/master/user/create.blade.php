<!-- Form Create -->
<form id="form-user">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama ">
                <div id="nameFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukan Email">
                <div id="emailFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="xxxxxxxxx">
                <div id="passwordFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="role" class="form-label">Roles</label>
                <select class="js-example-basic-single form-select form-select-sm" id="role" name="role">
                    <option value="">-- Pilih --</option>
                    @foreach ($role as $item)
                        <option value="{{ $item->name }}">{{ ucwords($item->name) }}</option>
                    @endforeach
                </select>
                <div id="roleFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="organization_id" class="form-label">Organisasi</label>
                <select class="js-example-basic-single form-select form-select-sm" id="organization_id" name="organization_id">
                    <option value="">-- Pilih --</option>
                    @foreach ($organization as $item)
                        <option value="{{ $item->id }}">{{ ucwords($item->name) }}</option>
                    @endforeach
                </select>
                <div id="organizationFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary mb-3" onclick="store()">Submit</button>
</form>
