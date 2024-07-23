@extends('master.layout.index')

@section('content')
    
<div class="main-content">
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Profil</h1>
    </div>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="card" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-body">
                        <form action="{{ route('profilUpdate') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <h5 class="py-2"><i class="ti-info"></i> Informasi Akun</h5>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ ucwords(Auth::user()->name) }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ Auth::user()->email }}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="08XXXXXXXXX" value="{{ Auth::user()->phone }}">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="image" class="form-label">Foto</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                    @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <h5 class="py-2"><i class="ti-wallet"></i> Informasi Rekening</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="account_owner" class="form-label">Pemilik Rekening</label>
                                    <input type="text" class="form-control @error('account_owner') is-invalid @enderror" id="account_owner" name="account_owner" value="{{ ucwords(Auth::user()->account_owner) }}" placeholder="Masukkan Pemilik Rekening">
                                    @error('account_owner')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="account_number" class="form-label">Nomor Rekening</label>
                                    <input type="number" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ Auth::user()->account_number }}" placeholder="Masukkan Nomor Rekening">
                                    @error('account_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="bank_name" class="form-label">Nama Bank</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ ucwords(Auth::user()->bank_name) }}" placeholder="Masukkan Nama Bank">
                                    @error('bank_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <h5 class="py-2"><i class="ti-world"></i> Informasi Organisasi</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="name_organization" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name_organization') is-invalid @enderror" id="name_organization" name="name_organization" value="{{ ucwords(Auth::user()->organization->name) }}">
                                    @error('name_organization')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="logo" class="form-label">Logo Organisasi</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                                    @error('logo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="structure_image" class="form-label">Struktur Organisasi</label>
                                    <input type="file" class="form-control @error('structure_image') is-invalid @enderror" id="structure_image" name="structure_image">
                                    @error('structure_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Deskripsi Organisasi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Masukan Deskripsi Seperti Tentang Organisasi, Visi, Misi dll.">{{ Auth::user()->organization->description }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <h5 class="py-2"><i class="ti-lock"></i> Ubah Password</h5>
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password Baru">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password Baru">
                                </div>

                            </div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-2" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Foto Akun</h5>
                                <div class="text-center my-3">
                                    <img src="{{ asset('storage/image-profil/' . Auth::user()->image) }}" class="img-thumbnail" alt="Foto Profil" style="width: 100%; border-radius: 15px; overflow: hidden;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Logo Organisasi</h5>
                                <div class="text-center my-3">
                                    <img src="{{ asset('storage/image-organizations/'. Auth::user()->organization->logo) }}" class="img-thumbnail" alt="Foto Profil" style="width: 100%; border-radius: 15px; overflow: hidden;">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h5>Struktur Organisasi</h5>
                                <div class="text-center my-3">
                                    <img src="{{ asset('storage/image-organizations/'. Auth::user()->organization->structure_image) }}" class="img-thumbnail" alt="Foto Profil" style="width: 100%; object-fit: cover; border-radius: 15px; overflow: hidden;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
