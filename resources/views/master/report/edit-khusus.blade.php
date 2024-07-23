<form id="form-submission-report-khusus" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="document" class="form-label">Dokumen</label>
                <span class="text-danger" style="font-size: 13px;">*Format: PDF*</span>
                <input type="file" class="form-control" id="document" name="document">
                <div id="documentFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="status" class="form-label ">Status</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="status_waiting" value="waiting" {{ $report->status == 'waiting' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_waiting">Menunggu Konfirmasi</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="status_rejected" value="rejected" {{ $report->status == 'rejected' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_rejected">Pengajuan Ditolak</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="status_approved" value="approved" {{ $report->status == 'approved' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_approved">Pengajuan Diterima</label>
                    </div>
                    <div id="statusFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="note" class="form-label">Catatan</label>
                <textarea class="form-control" id="note" name="note" placeholder="Optional" rows="3">{{ $report->note}}</textarea>
                <div id="noteFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <label class="form-label">Dokumen Laporan</label>
            <div class="mb-3">
                <iframe src="{{ asset('storage/document_reports/'. $report->document)}}" frameborder="0" class="w-100"></iframe>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary mb-3" onclick="update_khusus({{$report->id}})">Update</button>
        </div>
    </div>
</form>