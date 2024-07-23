<form id="form-submission-report" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="event" class="form-label">Nama Event</label>
                <select name="event" id="event" class="form-select">
                    <option selected>Pilih Event</option>
                    @foreach ($event as $item)
                        <option value="{{ $item->event_name }}">{{ $item->event_name }}</option>
                    @endforeach
                </select>
                <div id="eventFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="document" class="form-label">Dokumen</label>
                <span class="text-danger" style="font-size: 13px;">*Format : PDF*</span>
                <input type="file" class="form-control" id="document" name="document" >
                <div id="documentFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description"  placeholder="Masukan Deskripsi Event" rows="3"></textarea>
                <div id="descriptionFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary mb-3" onclick="store()">Submit</button>
</form>