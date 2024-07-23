<form id="form-event-khusus" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row mb-3">
        <h5 class="mb-3"><i class="ti-calendar"></i> Data Event</h5>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="event_name" class="form-label">Nama Event</label>
                <input type="text" class="form-control" id="event_name" name="event_name" value="{{ $event->event_name }}" disabled>
            </div>
        </div>        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="organization" class="form-label">Penyelenggara</label>
                <input type="text" class="form-control" id="organization" name="organization" value="{{ $event->organization->name }}" disabled>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="submission_status" class="form-label">Status Pengajuan</label>
                <select name="submission_status" id="submission_status" class="form-control" required>
                    <option value="waiting" {{ $submission->submission_status == 'waiting' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="rejected" {{ $submission->submission_status == 'rejected' ? 'selected' : '' }}>Pengajuan Ditolak</option>
                    <option value="approved" {{ $submission->submission_status == 'approved' ? 'selected' : '' }}>Pengajuan Diterima/Publish</option>
                </select>
                <div id="submission_statusFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="document_proposal" class="form-label">Dokumen Proposal</label>
                <span class="text-danger" style="font-size: 13px;">*Format : PDF*</span>
                <input type="file" class="form-control" id="document_proposal" name="document_proposal" accept=".pdf,.docx">
                <div id="document_proposalFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="document_rab" class="form-label">Dokumen RAB</label>
                <span class="text-danger" style="font-size: 13px;">*Format : PDF*</span>
                <input type="file" class="form-control" id="document_rab" name="document_rab" accept=".pdf,.docx">
                <div id="document_rabFeedback" class="invalid-feedback"></div>
            </div>
        </div>    
        <div class="col-md-12">
            <div class="mb-3">
                <label for="submission_note" class="form-label">Catatan Pengajuan</label>
                <textarea class="form-control" id="submission_note" name="submission_note" required>{{ $submission->submission_note }}</textarea>
                <div id="submission_noteFeedback" class="invalid-feedback"></div>
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

    <button type="submit" class="btn btn-primary mb-3" onclick="update_khusus({{$event->id}})">Update</button>
</form>
