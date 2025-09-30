@extends('layouts.customer')

@section('title', 'Checkout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Halaman Checkout</h4></div>
                <div class="card-body">
                    <h5>Informasi Pembeli</h5>
                    <table class="table table-bordered">
                        <tr>
                            <td width="25%">Nama</td>
                            <td width="10px">:</td>
                            <td>{{ $customer['name'] }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Email</td>
                            <td width="10px">:</td>
                            <td>{{ $customer['email'] }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Jenis Order</td>
                            <td width="10px">:</td>
                            <td>{{ $customer['order_type'] }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Alamat Tujuan</td>
                            <td width="10px">:</td>
                            <td>{{ $customer['delivery_address'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td width="25%">Catatan</td>
                            <td width="10px">:</td>
                            <td>{{ $customer['notes'] ?? '-' }}</td>
                        </tr>
                    </table>
                    <hr class="my-6" style="color: pink; border: 2px solid">
                    <H5>Detail Pesanan</H5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Menu</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $id => $order_item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order_item['name'] }}</td>
                                <td>Rp {{ number_format($order_item['price'], 0, ',', '.') }}</td>
                                <td>{{ $order_item['qty'] }}</td>
                                <td>Rp {{ number_format($order_item['price'] * $order_item['qty'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        @php
                            $total_price = 0;
                            foreach ($cart as $order_item) {
                                $total_price += $order_item['price'] * $order_item['qty'];
                            }
                        @endphp
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-center">Total</td>
                                <td>Rp {{ number_format($total_price, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <form action="{{ route('order.placeOrder') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-end mt-5">
                        <a href="{{ route('order.cart') }}" class="btn btn-secondary">
                            <span class="ti ti-arrow-left me-1"></span>Kembali ke keranjang</a>
                        <button type="submit" class="btn btn-danger ms-2">Buat Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection