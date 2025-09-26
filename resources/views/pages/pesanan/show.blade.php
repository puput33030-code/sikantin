@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Pesanan</h4>
                </div>
                <div class="card-body">
                    <h5>Pesanan #{{ $order->id }}</h5>
                    <p><strong>Nama Pemesan:</strong> {{ $order->name }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Dipesan pada:</strong> {{ $order->created_at->format('d F Y') }} pukul {{ $order->created_at->format('H:i') }}</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->order_items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->menus->name }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>Rp {{ number_format($item->menus->price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    <td>{{ $order->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Total Harga:</strong></td>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="d-flex mt-5">
                        <a href="{{ route('orderr.index') }}" class="btn btn-secondary"><span class="ti ti-arrow-left me-1"></span>Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection