@extends('layouts.app')

@section('title', 'Detail Menu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h4 class="page-title">Detail Menu</h4>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="1">
                                <img src="{{ asset('storage/images/' . $menus->image) }}" width="300">
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">ID</td>
                            <td width="10px">:</td>
                            <td>{{ $menus->id }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Nama</td>
                            <td width="10px">:</td>
                            <td>{{ $menus->name }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Kategori</td>
                            <td width="10px">:</td>
                            <td>{{ $menus->categories->category }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Harga</td>
                            <td width="10px">:</td>
                            <td>Rp {{ number_format($menus->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Stock</td>
                            <td width="10px">:</td>
                            <td>{{ $menus->stock }}</td>
                        </tr>
                        <tr>
                            <td width='25%'>Images</td>
                            <td width='10px'>:</td>
                            <td>{{ $menus->image }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Terdaftar pada</td>
                            <td width="10px">:</td>
                            <td>{{ $menus->created_at->isoFormat('DD MMM Y HH:mm') }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Diperbarui pada</td>
                            <td width="10px">:</td>
                            <td>{{ $menus->updated_at->isoFormat('DD MMM Y HH:mm') }}</td>
                        </tr>
                    </table>
                    <div class="d-flex mt-5">
                        <a href="{{ route('menu.index') }}" class="btn btn-secondary"><span class="ti ti-arrow-left me-1"></span>Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection