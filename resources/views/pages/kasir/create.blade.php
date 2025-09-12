@extends('layouts.app')

@section('title', 'Tambah Kasir')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Tambah Kasir</h3>
            <div class="card card-body">
                <form action="{{ route('kasir.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-6">
                        <label for="name">Nama Kasir</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name') }}" placeholder="Nama Kasir">
                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email') }}" placeholder="Email">
                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-6">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control"
                        value="{{ old('password') }}" placeholder="Password">
                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="flex">
                        <button type="submit" class="btn btn-primary">
                            <span class="ti ti-send me-1"></span>Simpan</button>
                        <a href="{{ route('kasir.index') }}" class="btn btn-secondary">
                            <span class="ti ti-x me-1"></span>Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
