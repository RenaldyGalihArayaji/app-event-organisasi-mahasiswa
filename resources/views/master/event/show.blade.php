<div class="row mb-3">
    <h5 class="mb-3"><i class="ti-calendar"></i> Data Event</h5>

    <div class="col-md-8">
        <div class="row">
            <!-- Left column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="event_name" class="form-label">Nama Event</label>
                    <input type="text" class="form-control" id="event_name" value="{{ ucwords($event->event_name) }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori Event</label>
                    <input type="text" class="form-control" id="category_id" value="{{ ucwords($event->category->name) }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="text" class="form-control" id="start_date" value="{{ date('d F Y - H:i', strtotime($event->start_date)) }} WIB" disabled>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="text" class="form-control" id="end_date" value="{{ date('d F Y - H:i', strtotime($event->end_date)) }} WIB" disabled>
                </div>
                <div class="mb-3">
                    <label for="method_type" class="form-label">Metode Event</label>
                    <input type="text" class="form-control" id="method_type" value="{{ $event->method_type == 'free' ? 'Gratis' : 'Berbayar' }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="activity" class="form-label">Aktivitas</label>
                    <input type="text" class="form-control" id="activity" value="{{ ucwords($event->activity) }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="event_status" class="form-label">Status Event</label>
                    <input type="text" class="form-control" id="event_status" value="{{ $event->end_date >= now() ? 'Aktif' : 'Tidak Aktif' }}" disabled>
                </div>
            </div>

            <!-- Right column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="event_price" class="form-label">Harga</label>
                    <input type="text" class="form-control" id="event_price" value="@currency($event->event_price)" disabled>
                </div>
                <div class="mb-3">
                    <label for="event_speaker" class="form-label">Narasumber</label>
                    <input type="text" class="form-control" id="event_speaker" value="{{ ucwords($event->event_speaker) }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="participant_quota" class="form-label">Kuota Peserta</label>
                    <input type="text" class="form-control" id="participant_quota" value="{{ $event->participant_quota }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="event_venue" class="form-label">Tempat Event</label>
                    <textarea class="form-control" id="event_venue" rows="3" disabled>{{ ucwords($event->event_venue) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="event_description" class="form-label">Deskripsi Event</label>
                    <textarea class="form-control" id="event_description" rows="3" disabled>{{ ucwords($event->event_description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Poster -->
    <div class="col-md-4">
        <label for="image" class="form-label">Gambar Poster</label>
        <div class="mb-3">
            <img src="{{ asset('storage/image-events/' . $event->event_image) }}" alt="Poster Event" class="img-fluid img-thumbnail" style="width: 100%; height: auto; object-fit: cover;">
        </div>
    </div>
</div>

<div class="row">
    <h5 class="mb-3"><i class="ti-money"></i> Data Pengajuan Dana</h5>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal Pengajuan</label>
                    <input type="text" class="form-control" id="date" value="{{ date('d F Y', strtotime($submission->created_at)) }}" disabled>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="date" class="form-label">Batas Tanggal Pengajuan</label>
                    <input type="text" class="form-control" id="date" value="{{ date('d F Y', strtotime($submission->deadline)) }}" disabled>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="submission_funds" class="form-label">Dana Pengajuan</label>
                    <input type="text" class="form-control" id="submission_funds" value="@currency($submission->submission_funds)" disabled>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="submission_note" class="form-label">Catatan</label>
                    <input type="text" class="form-control" id="submission_note" value="{{ ucwords($submission->submission_note) }}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="submission_status" class="form-label">Status Pengajuan</label>
                    <input type="text" class="form-control" id="submission_status" value="@if ($submission->submission_status == 'waiting') Menunggu Konfirmasi @elseif ($submission->submission_status == 'rejected') Data Ditolak @elseif ($submission->submission_status == 'approved') Event DiPublish @endif" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="document_proposal" class="form-label">Dokumen Proposal</label>
                    <a href="{{ route('component.downloadProposal', $submission->document_proposal) }}" class="btn btn-primary btn-sm w-100">Download <i class="ti-arrow-down"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="document_rab" class="form-label">Dokumen RAB</label>
                    <a href="{{ route('component.downloadRab', $submission->document_rab) }}" class="btn btn-success btn-sm w-100">Download <i class="ti-arrow-down"></i></a>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tampilan Proposal</label>
                <div class="mb-3">
                    <iframe src="{{ asset('storage/documents_proposal/' . $submission->document_proposal) }}" frameborder="0" class="w-100" style="height: 400px;"></iframe>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tampilan RAB</label>
                <div class="mb-3">
                    <iframe src="{{ asset('storage/documents_rab/' . $submission->document_rab) }}" frameborder="0" class="w-100" style="height: 400px;"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
