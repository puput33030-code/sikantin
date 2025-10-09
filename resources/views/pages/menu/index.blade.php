@extends('layouts.app')

@section('title', 'Data Menu')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4 class="page-title">Data Kasir</h4>
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('menu.create') }}" class="btn btn-primary">
                        <span class="ti ti-plus me-1"></span>Tambah Menu</a>
                </div>
                <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped dataTable">

                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Nama Menu</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $menu->categories->category }}</td>
                                    <td>{{ $menu->name }}</td>
                                    <td class="text-center">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('menu.show', $menu->id) }}" class="btn btn-secondary">
                                            <span class="ti ti-eye"></span></a>
                                        <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-primary ms-2">
                                            <span class="ti ti-pencil"></span></a>
                                        <a href="javascript:;" class="btn btn-danger ms-2"
                                        onclick="actionDelete('{{ route('menu.destroy', $menu->id) }}')">
                                            <span class="ti ti-trash"></span></a>
                                    </td>
                                </tr>
                            @endforeach
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