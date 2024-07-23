<div class="row">    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="organisasi" class="form-label">Penyelenggara</label>
            <input type="text" class="form-control" id="organisasi"  value="{{ ucwords($report->organization)}}" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="title" class="form-label">Nama Event</label>
            <input type="text" class="form-control " id="title"   value="{{ ucwords($report->event)}}" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="date" class="form-label">Tanggal Pengajuan</label>
            <input type="text" class="form-control" id="date"  value="{{ date('d F Y', strtotime($report->created_at)) }}" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
                @if ($report->status == 'waiting')
                    <input type="text" class="form-control" id="status"  value="Menunggu Konfirmasi" disabled>
                @endif
                @if ($report->status == 'rejected')
                    <input type="text" class="form-control" id="status"  value="Pengajuan Ditolak" disabled>
                @endif
                @if ($report->status == 'approved')
                    <input type="text" class="form-control" id="status"  value="Pengajuan Diterima" disabled>
                @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="note" class="form-label">Catatan</label>
            <textarea class="form-control" id="note"  rows="3" disabled>{{ ucwords($report->note) }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description"  rows="3" disabled>{{ ucwords($report->description)}}</textarea>
        </div>
    </div>                                        
    <div class="col-md-12">
        <label class="form-label">Dokumen Laporan</label>
        <div class="mb-3">
            <iframe src="{{ asset('storage/document_reports/'. $report->document)}}" frameborder="0" class="w-100"></iframe>
        </div>
    </div>
</div>