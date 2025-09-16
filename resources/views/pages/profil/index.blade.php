@extends('layouts.app')

@section('title', 'Profil')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" style="text-align: center;">Profil</h4>
                <div class="row mt-5">
                    <div class="col-md-4 d-flex flex-column align-items-center">
                        <img src="{{ $user->images ? asset('storage/images/'.$user->images) : 'https://via.placeholder.com/150' }}"
                            alt="Foto Profil"
                            style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px;">
                    </div>
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr>
                                <td width="25%">Nama</td>
                                <td width="10px">:</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td width="25%">Email</td>
                                <td width="10px">:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td width="25%">Password</td>
                                <td width="10px">:</td>
                                <td>********</td>
                            </tr>
                            <tr>
                                <td width="25%">Terdaftar pada</td>
                                <td width="10px">:</td>
                                <td>{{ $user->created_at->isoFormat('DD MMM Y HH:mm') }}</td>
                            </tr>
                            <tr>
                                <td width="25%">Diperbarui pada</td>
                                <td width="10px">:</td>
                                <td>{{ $user->updated_at->isoFormat('DD MMM Y HH:mm') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-5">
                        <a href="{{ route('home', $user->id) }}" class="btn btn-secondary">
                            <span class="ti ti-arrow-left me-1"></span>Kembali</a>
                        <a href="{{ route('ubah-profil.edit', $user->id) }}" class="btn btn-primary ms-2">
                            <span class="ti ti-pencil me-1"></span>Ubah Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" /> 
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    @if (Session::has('success'))
        <script type="text/javascript">
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ Session::get('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
        </script>
    @endif
@endpush