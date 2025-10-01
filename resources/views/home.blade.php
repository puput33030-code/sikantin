@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="container">
    <h4>Dashboard</h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>5 Pesanan Terbaru:</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Menu</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->name }}</td>
                                <td>
                                    @foreach ($order->order_items as $item)
                                        {{ $item->menus->name }} ({{ $item->qty }})@if (!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('orderr.index') }}" class="btn btn-primary">Lihat Semua Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Pesanan</h5>
                </div>

                <div class="card-body">
                    <canvas id="chart" class="chartjs" data-height="500"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('/vendor/libs/chartjs/chartjs.js') }}"></script>
    <script type="text/javascript">
        var chart = new Chart(document.getElementById('chart'), {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    data: @json($data),
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush