@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Laporan Harian</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('laporan.harian') }}" class="mb-3">
                        <label for="tanggal">Pilih Tanggal:</label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ $tanggal }}">
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </form>

                    <h5>Tanggal: {{ $tanggal }}</h5>
                    <p><strong>Total Pesanan:</strong> {{ $summary['total_pesanan'] }}</p>
                    <p><strong>Total Pendapatan:</strong> Rp {{ number_format($summary['total_price'], 0, ',', '.') }}</p>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Nama Pemesan</th>
                                <th>Status</th>
                                <th>Total Harga</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->name ?? '-' }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>{{ $order->created_at->format('H:i') }}</td>
                                </tr>
                            @endforeach
                            @if ($orders->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada data pesanan.</td>
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
