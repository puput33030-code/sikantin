@extends('layouts.app')

@section('title', 'Tambah Kasir')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-body">
                <form action="{{ route('kasir.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Kasir</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama Kasir">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Tambah Kasir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
