<form id="form-sponsorship" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $sponsorship->name}}">
                <div id="nameFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $sponsorship->email}}">
                <div id="emailFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="amount" class="form-label">Pendanaan</label>
                <input type="text" class="form-control" id="amount" name="amount" value="{{ $sponsorship->amount}}">
                <div id="amountFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $sponsorship->phone}}">
                <div id="phoneFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control" id="address" name="address" rows="3">{{ $sponsorship->address}}</textarea>
                <div id="addressFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary mb-3" onclick="update({{$sponsorship->id}})">Update</button>
</form>
