@extends('master.layout.index')

@section('content')
    
    <div class="main-content">
        <div class="title">
            <h1 class="h3 mb-0 text-gray-800">Pengaturan| <span class="text-secondary fs-5">Layout</span></h1>
        </div>
        <div class="content-wrapper">
            <div class="row same-height">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5><i class="ti-settings"></i> Informasi Akun</h5>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <form class="row g-3" action="{{ route('settingUpdate', $setting->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <input type="hidden" name="id" value="{{$setting->id}}">
                                <div class="row mt-3">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="app_name" class="form-label">Nama Aplikasi</label>
                                                <input type="text" name="app_name" id="app_name" class="form-control @error('app_name') is-invalid @enderror" value="{{ $setting->app_name}}">
                                                @error('app_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="app_logo" class="form-label">Logo Aplikasi</label>
                                                <input type="file" name="app_logo" id="app_logo" class="form-control @error('app_logo') is-invalid @enderror">
                                                @error('app_logo')
                                                    <div class="invalid-feedback">
                                                        {{ $message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hero_name" class="form-label">Judul Hero Section</label>
                                                <input type="text" name="hero_name" id="hero_name" class="form-control @error('hero_name') is-invalid @enderror" value="{{ $setting->hero_name}}">
                                                @error('hero_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="hero_image" class="form-label">Gambar Hero Section</label>
                                                <input type="file" name="hero_image" id="hero_image" class="form-control @error('hero_image') is-invalid @enderror">
                                                @error('hero_image')
                                                    <div class="invalid-feedback">
                                                        {{ $message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="contact_phone" class="form-label">Nomor Telepon</label>
                                                <input type="number" name="contact_phone" id="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" value="{{ $setting->contact_phone}}">
                                                @error('contact_phone')
                                                    <div class="invalid-feedback">
                                                        {{ $message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="contact_email" class="form-label">Email</label>
                                                <input type="email" name="contact_email" id="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ $setting->contact_email}}">
                                                @error('contact_email')
                                                    <div class="invalid-feedback">
                                                        {{ $message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="youtube_url" class="form-label">URL Youtube</label>
                                                <input type="text" name="youtube_url" id="youtube_url" class="form-control" placeholder="https://" value="{{ $setting->youtube_url}}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="instagram_url" class="form-label">URL Instagram</label>
                                                <input type="text" name="instagram_url" id="instagram_url" class="form-control" placeholder="https://" value="{{ $setting->instagram_url}}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="facebook_url" class="form-label">URL Facebook</label>
                                                <input type="text" name="facebook_url" id="facebook_url" class="form-control" placeholder="https://" value="{{ $setting->facebook_url}}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="short_description" class="form-label">Deskripsi Singkat</label>
                                                <textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror">{{ $setting->short_description}}</textarea>
                                                @error('short_description')
                                                    <div class="invalid-feedback">
                                                        {{ $message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="contact_address" class="form-label">Alamat</label>
                                                <textarea name="contact_address" id="contact_address" class="form-control @error('contact_address') is-invalid @enderror">{{ $setting->contact_address}}</textarea>
                                                @error('contact_address')
                                                    <div class="invalid-feedback">
                                                        {{ $message}}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-2">
                                        <img src="{{ asset('storage/image_settings/'. $setting->hero_image) }}" alt="" class="img-thumbnail" style="width: 100%; height: 30vh; object-fit: cover;">
                                    </div>
                                </div>
        
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mb-2">Perbarui</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

