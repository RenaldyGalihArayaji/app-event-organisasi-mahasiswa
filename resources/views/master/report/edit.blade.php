<form id="form-submission-report" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="event" class="form-label">Nama Event</label>
                <select name="event" id="event" class="form-control" required>
                    <option selected value="{{ $report->event }}">{{ $report->event }}</option>
                    @foreach ($events as $item)
                        <option value="{{ $item->event_name }}">{{ $item->event_name }}</option>
                    @endforeach
                </select>
                <div id="eventFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="document" class="form-label">Dokumen</label>
                <span class="text-danger" style="font-size: 13px;">*Format: PDF*</span>
                <input type="file" class="form-control" id="document" name="document">
                <div id="documentFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $report->description }}</textarea>
                <div id="descriptionFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <label class="form-label">Dokumen Laporan</label>
            <div class="mb-3">
                <iframe src="{{ asset('storage/document_reports/'. $report->document)}}" frameborder="0" class="w-100"></iframe>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary mb-3" onclick="update({{ $report->id }})">Update</button>
        </div>
    </div>
</form>
