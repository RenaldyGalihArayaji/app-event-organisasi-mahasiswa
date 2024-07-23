<div class="row">
    <!-- Bagian Input -->
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ ucwords($sponsorship->name)}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"  value="{{ $sponsorship->email}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="amount" class="form-label">Pendanaan</label>
                    <input type="text" class="form-control" id="amount" name="amount" value="@currency($sponsorship->amount)">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $sponsorship->phone}}">
                    <div id="phoneFeedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="link_sosmed" class="form-label">Link SosMed</label>
                    <input type="text" class="form-control" id="link_sosmed" name="link_sosmed"  value="{{ $sponsorship->link_sosmed}}">
                    <div id="link_sosmedFeedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ ucwords($sponsorship->address)}}</textarea>
                    <div id="addressFeedback" class="invalid-feedback"></div>
                </div>
            </div>
    
        </div>
    </div>
</div>
