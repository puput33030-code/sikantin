@extends('layouts.customer')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="card">
            <h4 class="card-header">Keranjang Belanja</h4>
            <div class="card-body">
                <table class="table table-bordered dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalPrice = 0;
                        @endphp
                        @foreach ($cart as $id => $item)
                        @php 
                            $subtotal = $item['price'] * $item['qty'];
                            $totalPrice += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    {{-- Tombol Kurang --}}
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="me-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="qty" value="{{ $item['qty'] - 1 }}">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary"
                                            @if($item['qty'] <= 1) disabled @endif>-</button>
                                    </form>

                                    {{-- Jumlah --}}
                                    <span class="mx-2">{{ $item['qty'] }}</span>

                                    {{-- Tombol Tambah --}}
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="ms-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="qty" value="{{ $item['qty'] + 1 }}">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">+</button>
                                    </form>
                                </div>
                            </td>

                            <td>{{ $item['qty'] }}</td>
                            <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-danger"
                                    onclick="actionDelete('{{ route('cart.delete', $id) }}')">
                                    <span class="ti ti-trash"></span></a>
                            </td>
                        </tr>
                        @endforeach
                        @if (empty($cart))
                            <tr>
                                <td colspan="6" class="text-center text-muted">Keranjang Belanja Kosong</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-center">Total Harga</td>
                            <td colspan="2">Rp{{ number_format($totalPrice, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
                <hr class="my-6" style="color: pink; border: 2px solid">
                <div class="page-title">
                    <h4>Form Pemesanan</h4>
                </div>
                <form action="{{ route('order.saveCustomer') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name') }}" placeholder="Nama">
                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email') }}" placeholder="Email">
                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="order_type">Jenis Order</label>
                        <select name="order_type" id="order_type" class="form-select @error('order_type') is-invalid @enderror">
                            <option value="">Pilih Jenis Order</option>
                            <option value="diambil">Diambil</option>
                            <option value="diantar">Diantar</option>
                        </select>
                        @error('order_type')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="delivery_address">Alamat Tujuan</label>
                        <textarea name="delivery_address" id="delivery_address" placeholder="Isi alamat tujuan jika memilih opsi diantar" class="form-control">{{ old('delivery_address') }}</textarea>
                        @error('delivery_address')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="notes">Catatan</label>
                        <textarea name="notes" id="notes" placeholder="Isi catatan jika ada" class="form-control">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end mt-5">
                        <a href="{{ route('order.index') }}" class="btn btn-secondary"><span class="ti ti-arrow-left me-1"></span>Kembali ke Menu</a>
                        <button type="submit" class="btn btn-danger ms-2">Lanjutkan Pesanan<span class="ti ti-arrow-right me-1"></span></button>
                    </div>
                </form>
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
    <script src="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.js') }}"></script>
    <script src="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
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
    @if (Session::has('error'))
        <script type="text/javascript">
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ Session::get('error') }}',
            showConfirmButton: true
        });
        </script>
    @endif
@endpush