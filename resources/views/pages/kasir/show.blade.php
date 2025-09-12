@extends('layouts.app')

@section('title', 'Detail Kasir')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h4 class="page-title">Detail Kasir</h4>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td width="25%">ID</td>
                            <td width="10px">:</td>
                            <td>{{ $users->id }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Nama</td>
                            <td width="10px">:</td>
                            <td>{{ $users->name }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Email</td>
                            <td width="10px">:</25td>
                            <td>{{ $users->email }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Terdaftar pada</td>
                            <td width="10px">:</td>
                            <td>{{ $users->created_at->isoFormat('DD MMM Y HH:mm') }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Diperbaharui pada</td>
                            <td width="10px">:</td>
                            <td>{{ $users->updated_at->isoFormat('DD MMM Y HH:mm') }}</td>
                        </tr>
                    </table>
                    <div class="flex mt-5">
                        <a href="{{ route('kasir.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection