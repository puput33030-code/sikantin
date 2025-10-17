@extends('layouts.app')

@section('title', 'Data Pesanan')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4 class="page-title">Data Pesanan</h4>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped dataTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Pemesan</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Jenis Order</th>
                                <th class="text-center">Total Harga</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td class="text-center">{{ $order->order_type }}</td>
                                <td class="text-center">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="text-center"><form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-control">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="siap" {{ $order->status == 'siap' ? 'selected' : '' }}>Siap</option>
                                        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    <button type="submit" class="btn btn-info mt-2 align-self-center">Update</button>
                                </form>
                                </td>
                                <td>
                                    <a href="{{ route('orderr.show', $order->id) }}" class="btn btn-primary align-self-center">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                            @if ($orders->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum Ada Pesanan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $(function () {
            $('.dataTable').DataTable();
        });
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
            title: 'Gagal',
            text: '{{ Session::get('error') }}',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif
@endpush