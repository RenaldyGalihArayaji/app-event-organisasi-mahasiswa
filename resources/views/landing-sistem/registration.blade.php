<form id="form-registration" enctype="multipart/form-data">
    @csrf
    <div class="row">
        {{-- Informasi --}}
        @if ($event->method_type == 'paid')
            <div class="col-lg-12 mb-3">
                <div class="event-info bg-danger-subtle p-3" style="border-radius: 15px; overflow: hidden;" data-aos="fade-up" data-aos-delay="200">
                    <p class="text-center">
                        Silakan transfer pembayaran melalui nomor rekening berikut:
                        <br>
                        <strong>Bank:</strong> {{ ucwords($event->user->bank_name)}}
                        <br>
                        <strong>Nomor Rekening:</strong> {{ $event->user->account_number}}
                        <br>
                        <strong>Atas Nama:</strong> {{ ucwords($event->user->account_owner)}}
                        <br><br>
                        Setelah transfer selesai, silakan isi formulir dan unggah bukti pembayaran. Kami akan mengonfirmasi pembayaran Anda melalui email. Harap cek email Anda secara berkala.
                    </p>
                </div>
            </div>
        @else
            <div class="col-lg-12 mb-3">
                <div class="event-info bg-danger-subtle p-3" style="border-radius: 15px; overflow: hidden;" data-aos="fade-up" data-aos-delay="200">
                    <p class="text-center">
                        Silakan isi formulir dengan benar. Setelah selesai, klik submit. Kami akan mengonfirmasi pendaftaran Anda melalui email. Harap cek email Anda secara berkala.
                    </p>
                </div>
            </div>
        @endif
    

        <input type="hidden" name="event_id" value="{{ $event->id }}">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="event" class="form-label">Nama Event</label>
                <input type="text" class="form-control" id="event" name="event" value="{{ ucwords($event->event_name)}}" disabled>
            </div>
        </div>
        @if ($event->method_type == 'paid')
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="text" class="form-control" id="price" name="price" value="@currency($event->event_price)" disabled>
                </div>
            </div>
        @endif

        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name"  placeholder="Masukan Nama Lengkap">
                <div id="nameFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim"  placeholder="Masukan NIM">
                <div id="nimFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="prodi" class="form-label">Program Studi</label>
                <input type="text" class="form-control" id="prodi" name="prodi"  placeholder="Masukan Program Studi">
                <div id="prodiFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        @if ($event->method_type == 'paid')
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"  placeholder="Masukan Email">
                    <div id="emailFeedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone"  placeholder="Masukan Nomor Telepon">
                    <div id="phoneFeedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="proof_payment" class="form-label">Bukti Pembayaran</label>
                    <input type="file" class="form-control" id="proof_payment" name="proof_payment"  placeholder="Masukan Nomor Telepon">
                    <div id="proof_paymentFeedback" class="invalid-feedback"></div>
                </div>
            </div>
        @else
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"  placeholder="Masukan Email">
                    <div id="emailFeedback" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone"  placeholder="Masukan Nomor Telepon">
                    <div id="phoneFeedback" class="invalid-feedback"></div>
                </div>
            </div>
        @endif
    </div>
    
    <button type="submit" class="btn btn-primary mb-3" onclick="prosesRegistration()">Submit</button>
</form>