<form id="form-category">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
                <div id="nameFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    
    <button type="button" class="btn btn-primary mb-3" onclick="update({{ $category->id }})">Update</button>
</form>