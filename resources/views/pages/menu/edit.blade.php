@extends('layouts.app')

@section('title', 'Ubah Menu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ubah Menu</div>

                    <div class="card-body">
                        <form action="{{ route('menu.update', $menus->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-6">
                                <label for="name" class="form-label">Nama Menu</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $menus->name }}" />
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
                                <input type="number" class="form-control" id="price" name="price" value="{{ $menus->price }}" />
                                @error('price')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="{{ $menus->stock }}" />
                                @error('stock')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <label for="images" class="form-label">Gambar</label>
                                <input type="file" name="images" id="images" class="form-control">
                                <img src="{{ asset('storage/images/'.$products->images) }}" alt="" width="100">
                                @error('images')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-flex mt-5">
                            <a href="{{ route('menu.index') }}" class="btn btn-secondary"><span class="ti ti-x me-1"></span>Batal</a>
                            <button type="submit" class="btn btn-primary"><span class="ti ti-send me-1"></span>Simpan</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection