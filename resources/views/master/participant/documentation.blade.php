<form id="form-dokumentasi" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="image" class="form-label">Gambar <span class="text-danger">*</span></label>
                <input type="file" class="form-control" id="image" name="image">
                <div id="imageFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="youtube_url" class="form-label">URL Youtube</label>
                <input type="text" class="form-control" id="youtube_url" name="youtube_url" placeholder="Optional">
                <div id="youtube_urlFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="gDrive_url" class="form-label">URL Google Drive</label>
                <input type="text" class="form-control" id="gDrive_url" name="gDrive_url" placeholder="Optional">
                <div id="gDrive_urlFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description"></textarea>
                <div id="descriptionFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary mb-3" onclick="uploadDocumentation({{$event->id}})">Submit</button>
        </div>
    </div>
</form>