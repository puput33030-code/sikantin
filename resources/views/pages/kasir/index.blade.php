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
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Kasir</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $kasir)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $kasir->name }}</td>
                                <td>{{ $kasir->email }}</td>
                                <td class="text-center">
                                    <div class="action-btns">
                                    <a href="{{ route('kasir.show', $kasir->id) }}" class="action-btn" style="background-color: var(--bs-secondary)">
                                        <span class="action-btn-icon material-symbols-rounded">visibility</span>
                                        <span class="action-btn-title">Detail</span></a>
                                    <a href="javascript:;" class="action-btn" style="background-color: var(--bs-danger)"
                                    onclick="actionDelete('{{ route('kasir.destroy', $kasir->id) }}')">
                                        <span class="action-btn-icon material-symbols-rounded">delete</span>
                                        <span class="action-btn-title">Hapus</span></a>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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