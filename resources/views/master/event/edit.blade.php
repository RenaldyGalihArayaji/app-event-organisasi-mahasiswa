<form id="form-event" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row mb-3">
        <h5 class="mb-3"><i class="ti-calendar"></i> Data Event</h5>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="event_name" class="form-label">Nama Event</label>
                <input type="text" class="form-control" id="event_name" name="event_name" value="{{ $event->event_name }}" required>
                <div id="event_nameFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori Event</label>
                <select name="category_id" class="form-control" id="category_id" required>
                    <option value="{{ $event->category->id }}">{{ ucwords($event->category->name) }}</option>
                    @foreach ($category as $a)
                        <option value="{{ $a->id }}">{{ $a->name }}</option>
                    @endforeach
                </select>
                <div id="category_idFeedback" class="invalid-feedback"></div>
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
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ $event->start_date }}" required>
                <div id="start_dateFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ $event->end_date }}" required>
                <div id="end_dateFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="method_type" class="form-label">Metode Event</label>
                <select name="method_type" id="method_type" class="form-control" required>
                    <option value="free" {{ $event->method_type == 'free' ? 'selected' : '' }}>Gratis</option>
                    <option value="paid" {{ $event->method_type == 'paid' ? 'selected' : '' }}>Berbayar</option>
                </select>
                <div id="method_typeFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="activity" class="form-label">Aktifitas</label>
                <select name="activity" id="activity" class="form-control" required>
                    <option value="online" {{ $event->activity == 'online' ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ $event->activity == 'offline' ? 'selected' : '' }}>Offline</option>
                </select>
                <div id="activityFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="event_price" class="form-label">Harga</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="number" class="form-control" id="event_price" name="event_price" value="{{ $event->event_price }}" required>
                </div>
                <div id="priceFeedback" class="invalid-feedback"></div>
            </div>
        </div>  
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="event_speaker" class="form-label">Narasumber</label>
                <input type="text" class="form-control" id="event_speaker" name="event_speaker" placeholder="optional" value="{{ $event->event_speaker }}">
                <div id="speakerFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="participant_quota" class="form-label">Kuota Peserta</label>
                <input type="text" class="form-control" id="participant_quota" name="participant_quota" value="{{ $event->participant_quota }}" required>
                <div id="participant_quotaFeedback" class="invalid-feedback"></div>
            </div>
        </div>        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Poster</label>
                <img src="{{ asset('storage/image-events/'. $event->event_image) }}" alt="" width="30">
                <input type="file" class="form-control" id="image" name="event_image" accept="image/*">
                <div id="imageFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="event_venue" class="form-label">Tempat Event</label>
                <textarea class="form-control" id="event_venue" name="event_venue" required>{{ $event->event_venue }}</textarea>
                <div id="event_venueFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="event_description" class="form-label">Deskripsi Event</label>
                <textarea class="form-control" id="event_description" name="event_description" required>{{ $event->event_description }}</textarea>
                <div id="event_descriptionFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <h5 class="mb-3"><i class="ti-money"></i> Data Pengajuan Dana</h5>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal Pengajuan</label>
                <input type="text" class="form-control" id="date" value="{{ date('d F Y', strtotime($submission->created_at)) }}" disabled>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="deadline" class="form-label">Batas Tanggal Pengajuan</label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline" value="{{ $submission->deadline }}" required>
                <div id="deadlineFeedback" class="invalid-feedback"></div>
            </div>
        </div> 

        <div class="col-md-4">
            <div class="mb-3">
                <label for="submission_funds" class="form-label">Dana Pengajuan</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="text" class="form-control" id="submission_funds" name="submission_funds" value="{{ $submission->submission_funds }}" required>
                </div>
                <div id="submission_fundsFeedback" class="invalid-feedback"></div>
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
    </div>
    
    <button type="submit" class="btn btn-primary mb-3" onclick="update({{$event->id}})">Update</button>
</form>
