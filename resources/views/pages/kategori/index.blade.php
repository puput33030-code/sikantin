@extends('layouts.app')

@section('title', 'Kategori Menu')
@section('content')
<div class="container">
    <div class="rowr">
        <div class="col-md-12">
            <h4 class="card-header">Kategori Menu</h4>
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                        <span class="ti ti-plus me-1"></span>Tambah Kategori</a>
                            <table class="table table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th class="border">No</th>
                                        <th class="border">Nama Kategori</th>
                                        <th class="border">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td class="border">{{ $loop->iteration }}</td>
                                        <td class="border">{{ $category->category }}</td>
                                        <td>
                                            <a href="{{ route('kategori.edit', $category->id) }}" class="btn btn-primary">
                                                <span class="ti ti-pencil me-1"></span>Edit</a>
                                            <a href="javascript:;" class="btn btn-danger"
                                            onclick="actionDelete('{{ route('kategori.destroy', $category->id) }}')">
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