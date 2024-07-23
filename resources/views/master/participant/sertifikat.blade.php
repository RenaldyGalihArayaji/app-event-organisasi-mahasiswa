<form id="form-sertifikat" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="document" class="form-label">Dokumen Sertifikat <span class="text-danger">*</span></label>
                <input type="file" class="form-control" id="document" name="document">
                <div id="documentFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary mb-3" onclick="uploadSertifikat({{$event->id}})">Submit</button>
        </div>
    </div>
</form>