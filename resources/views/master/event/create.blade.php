<form id="form-event" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">

        <h5 class="mb-3"><i class="ti-calendar"></i> Data Event</h5>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="event_name" class="form-label">Nama Event <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Masukan Nama Event">
                <div id="event_nameFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori Event <span class="text-danger">*</span></label>
                <select name="category_id" class="form-control" id="category_id">
                    <option value="" selected disabled>Pilih...</option>
                    @foreach ($category as $item)
                        <option value="{{ $item->id }}">{{ ucwords($item->name) }}</option>
                    @endforeach
                </select>
                <div id="category_idFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                <input type="datetime-local" class="form-control" id="start_date" name="start_date">
                <div id="start_dateFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="end_date" class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                <input type="datetime-local" class="form-control" id="end_date" name="end_date">
                <div id="end_dateFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="method_type" class="form-label">Metode Event <span class="text-danger">*</span></label>
                <select name="method_type" id="method_type" class="form-control">
                    <option value="" selected disabled>Pilih...</option>
                    <option value="free">Gratis</option>
                    <option value="paid">Berbayar</option>
                </select>
                <div id="method_typeFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="activity" class="form-label">Aktivitas <span class="text-danger">*</span></label>
                <select name="activity" id="activity" class="form-control">
                    <option value="" selected disabled>Pilih...</option>
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                </select>
                <div id="activityFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="event_price" class="form-label">Harga <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="event_price" name="event_price" placeholder="Kalau jenis metode Gratis tulis angka 0">
                <div id="event_priceFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="event_speaker" class="form-label">Narasumber <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="event_speaker" name="event_speaker" placeholder="optional">
                <div id="event_speakerFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="participant_quota" class="form-label">Kuota Peserta <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="participant_quota" name="participant_quota" placeholder="Masukan Kuota Peserta">
                <div id="participant_quotaFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="event_image" class="form-label">Gambar Poster <span class="text-danger">*</span></label>
                <input type="file" class="form-control" id="event_image" name="event_image">
                <div id="event_imageFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="event_venue" class="form-label">Tempat Event <span class="text-danger">*</span></label>
                <textarea class="form-control" id="event_venue" name="event_venue" placeholder="Masukan Tempat Event" rows="3"></textarea>
                <div id="event_venueFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="event_description" class="form-label">Deskripsi Event <span class="text-danger">*</span></label>
                <textarea class="form-control" id="event_description" name="event_description" placeholder="Masukan Deskripsi Event" rows="3"></textarea>
                <div id="event_descriptionFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <div class="row">

        <h5 class="mb-3"><i class="ti-money"></i> Data Pengajuan Dana</h5>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="submission_funds" class="form-label">Dana Pengajuan <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text ">Rp.</span>
                    <input type="text" class="form-control" id="submission_funds" name="submission_funds" placeholder="0000000">
                </div>
                <div id="submission_fundsFeedback" class="invalid-feedback"></div>
            </div>
        </div>        

        <div class="col-md-4">
            <div class="mb-3">
                <label for="document_proposal" class="form-label">Dokumen Proposal <span class="text-danger">*</span></label>
                <span class="text-danger" style="font-size: 13px;">*Format : PDF*</span>
                <input type="file" class="form-control" id="document_proposal" name="document_proposal" >
                <div id="document_proposalFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="document_rab" class="form-label">Dokumen RAB <span class="text-danger">*</span></label>
                <span class="text-danger" style="font-size: 13px;">*Format : PDF*</span>
                <input type="file" class="form-control" id="document_rab" name="document_rab" >
                <div id="document_rabFeedback" class="invalid-feedback"></div>
            </div>
        </div>

    </div>

    <button type="submit" class="btn btn-primary mb-3" onclick="store()">Submit</button>
</form>
