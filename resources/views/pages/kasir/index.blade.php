@extends('layouts.app')

@section('title', 'Data Kasir')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4 class="page-title">Data Kasir</h4>
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('kasir.create') }}" class="btn btn-primary">
                        <span class="ti ti-plus me-1"></span>Tambah Kasir</a>
                </div>
                <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped dataTable">

                        <thead>
                            <tr>
                                <th class="border">No</th>
                                <th class="border">Nama Kasir</th>
                                <th class="border">Email</th>
                                <th class="border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $kasir)
                            <tr>
                                <td class="border">{{ $loop->iteration }}</td>
                                <td class="border">{{ $kasir->name }}</td>
                                <td class="border">{{ $kasir->email }}</td>
                                <td class="border">
                                    <a href="{{ route('kasir.show', $kasir->id) }}" class="btn btn-primary">
                                        <span class="ti ti-eye"></span>Detail</a>
                                    <a href="javascript:;" class="btn btn-danger"
                                    onclick="actionDelete('{{ route('kasir.destroy', $kasir->id) }}')">
                                        <span class="ti ti-trash"></span>Hapus</a>
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

<form id="form-delete" action="" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />

@endpush

@push('scripts')
    <script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script type="text/javascript">
    $(function () {
        $('.dataTable').DataTable();
    });

    function actionDelete(url){
        Swal.fire({ 
        title: "Are you sure?",
        text: "You wan't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Back"
      }).then((result) => {
        if (result.isConfirmed) {
            $('#form-delete').attr('action', url);
            $('#form-delete').submit();
        }
      });
    }
    </script>

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