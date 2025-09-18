@extends('layouts.app')

@section('title', 'Kategori Menu')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
                <h4 class="card-header">Tambah Kategori Menu</h4>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('kategori.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="category" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" value="{{ old('category') }}" id="category" name="category" required>
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