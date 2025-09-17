@extends('layouts.app')

@section('title', 'Tambah Menu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tambah Menu</div>
                    <div class="card-body">
                        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-6">
                                <label for="name" class="form-label">Nama Menu</label>
                                <input type="text" class="form-control" value="{{ old('name') }}" id="name" name="name" />
                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" />
                                @error('price')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" />
                                @error('stock')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <label for="images" class="form-label">Gambar</label>
                                <input type="file" name="images" id="images" class="form-control">
                                @error('images')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <a href="{{ route('menu.index') }}" class="btn btn-secondary"><span class="ti ti-x me-1"></span>Batal</a>
                            <button type="submit" class="btn btn-primary"><span class="ti ti-send me-1"></span>Simpan</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection