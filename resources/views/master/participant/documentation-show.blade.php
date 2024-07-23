@php
    use App\Helpers\YouTubeHelper;
@endphp

<form id="form-dokumentasi" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <img src="{{ asset('storage/image-documentations/' . $event->documentation->image) }}" alt="" style="width: 100%; height: 50vh; object-fit: cover; object-position: center;" class="img-thumbnail img-fluid">
            </div>
        </div>
        @if ($event->documentation->youtube_url != '')
            <div class="col-md-12">
                <div class="mb-3">
                    <div class="embed-responsive embed-responsive-16by9" style="height: 50vh;">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ YouTubeHelper::getYouTubeVideoId($event->documentation->youtube_url) }}" allowfullscreen style="width: 100%; height: 100%;"></iframe>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="mb-3">
                <textarea name="" class="form-control" disabled>{{ $event->documentation->description }}</textarea>
            </div>
        </div>
        @if ($event->documentation->gDrive_url != '')
            <div class="col-md-12">
                <div class="mb-3">
                    <a href="{{ $event->documentation->gDrive_url }}" class="btn btn-primary btn-sm" target="_blank">Klik Google Drive</a>
                </div>
            </div>
        @endif
    </div>
</form>