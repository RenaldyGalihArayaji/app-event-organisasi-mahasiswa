<form id="form-sponsorship" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name"  placeholder="Masukan Nama Perusahaan">
                <div id="nameFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email"  placeholder="Masukan Email Perusahaan">
                <div id="emailFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="amount" class="form-label">Pendanaan <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="0000000">
                <div id="amountFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="08736xxxxxx">
                <div id="phoneFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                <textarea class="form-control" id="address" name="address"  placeholder="Masukan Alamat Perusahaan" rows="3"></textarea>
                <div id="addressFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary mb-3" onclick="store()">Submit</button>
        </div>
    </div>
</form>