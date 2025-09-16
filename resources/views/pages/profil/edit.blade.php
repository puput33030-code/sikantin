@extends('layouts.app')

@section('tittle', 'Ubah Profil')

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" style="text-align: center;">Ubah Profil</h4>

                <div class="row mt-5">
                    <!-- Bagian Upload Gambar -->
                    <div class="col-md-4 d-flex flex-column align-items-center">
                        <form action="{{ route('ubah-profil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="profile-upload-box border rounded d-flex justify-content-center align-items-center mb-2"
                            style="width: 200px; height: 200px; position: relative; cursor: pointer;">
                            
                            <input type="file" id="image" name="images" class="d-none" onchange="previewImage(event)">
                            
                            <img id="preview" src="{{ $user->images ? asset('storage/images/'.$user->images) : 'https://via.placeholder.com/150' }}"
                                alt="Foto Profil"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px;">
                            
                            <label for="image" class="upload-btn"
                                style="position: absolute; bottom: 10px; background: rgba(0,0,0,0.6); color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px; cursor: pointer;">
                                Ubah Foto
                            </label>
                                @error('images')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong> {{ $message }} </strong>
                                </span>
                                @enderror
                        </div>
                    </div>

                    <!-- Bagian Form -->
                    <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                                @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong> {{ $message }} </strong>
                                </span>
                                    
                                @enderror                 
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong> {{ $message }} </strong>
                                </span>
                                @enderror                 
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong> {{ $message }} </strong>
                                </span>
                                    
                                @enderror                 
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">
                                    Konfirmasi Password
                                </label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>

                            <div class="d-flex justify-content-end mt-5">
                                <a href="{{ route('ubah-profil') }}" class="btn btn-secondary"><span class="ti ti-x me-1"></span>Batal</a>
                                <button type="submit" class="btn btn-primary ms-2"><span class="ti ti-send me-1"></span>Simpan</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('preview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection
