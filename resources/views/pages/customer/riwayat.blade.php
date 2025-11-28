@extends('layouts.customer')

@section('content')
<div class="container mt-5">

    <h3 class="mb-4">Riwayat Pesanan untuk: <strong>{{ $email }}</strong></h3>

    @if($orders->isEmpty())
        <div class="alert alert-warning">Tidak ada riwayat pesanan ditemukan.</div>
    @else
        @foreach($orders as $order)
        <div class="card mb-4">
            <div class="card-header">
                <strong>Kode Pesanan:</strong> {{ $order->id }}  
                <span class="float-end">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</span>
            </div>

            <div class="card-body">
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Total Harga:</strong> Rp {{ number_format($order->total_price) }}</p>

                <h6>Detail Item:</h6>
                <ul>
                    @foreach($order->order_items as $item)
                        <li>
                            {{ $item->menus->name }}  
                            ({{ $item->qty }} × Rp {{ number_format($item->unit_price) }})
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
