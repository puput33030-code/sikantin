@extends('layouts.app')

@section('title', 'Data Kasir')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Kasir</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Kasir</th>
                                <th scope="col">Email</th>
                                <th scope="col">Image</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $kasir)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kasir->name }}</td>
                                <td>{{ $kasir->email }}</td>
                                <td><img src="{{ asset('storage/' . $kasir->images) }}" alt="" width="100"></td>
                                <td>
                                    <a href="{{ route('kasir.show', $kasir->id) }}" class="btn btn-secondary">
                                        <span class="ti ti-eye"></span></a>
                                    <a href="{{ route('kasir.edit', $kasir->id) }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ route('kasir.destroy', $kasir->id) }}" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection