@extends('layouts.app')

@section('title', 'Ubah Kategori')

@section('content')
<div class="container">    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <h4 class="card-header">Ubah Kategori Menu</h4>

                <div class="card-body">
                    <form action="{{ route('kategori.update', $categories->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="category" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="category" name="category" value="{{ $categories->category }}">
                            @error('category')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <a href="{{ route('kategori.index') }}" class="btn btn-secondary"><span class="ti ti-x me-1"></span>Batal</a>
                        <button type="submit" class="btn btn-primary"><span class="ti ti-send me-1"></span>Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection