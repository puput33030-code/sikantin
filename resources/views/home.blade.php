@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <i class="ti ti-check me-2"></i>
            <div>
                Selamat datang di halaman beranda admin
            </div>
        </div>
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
                                <tr style="background-color: var(--bs-primary);">
                                    <th class="text-center" style="color: #fff">No</th>
                                    <th class="text-center" style="color: #fff">Nama</th>
                                    <th class="text-center" style="color: #fff">Menu</th>
                                    <th class="text-center" style="color: #fff">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr class="bg-label-primary">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>
                                            @foreach ($order->order_items as $item)
                                                {{ $item->menus->name }} ({{ $item->qty }})@if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $order->status == 'pending'
                                                    ? 'secondary'
                                                    : ($order->status == 'diproses'
                                                        ? 'warning'
                                                        : ($order->status == 'siap'
                                                            ? 'info'
                                                            : ($order->status == 'selesai'
                                                                ? 'success'
                                                                : ($order->status == 'dibatalkan'
                                                                    ? 'danger'
                                                                    : 'secondary')))) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-8">
                            <a href="{{ route('orderr.index') }}" class="btn btn-label-info">Lihat Semua Pesanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: var(--bs-primary);">
                        <h5 class="card-title d-flex align-items-center text-white">Grafik Pesanan</h5>
                    </div>

                    <div class="card-body mt-4">
                        <canvas id="chart" class="chartjs" data-height="500"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: var(--bs-primary);">
                        <h5 class="card-title d-flex align-items-center text-white">Laporan Harian</h5>
                    </div>

                    <div class="card-body mt-8">
                        <h5><strong>Hari Ini: {{ $tanggal }} </strong></h5>
                        <h5><strong>Pesanan: {{ $summary['total_pesanan'] }} </strong></h5>
                        <h5><strong>Pendapatan: Rp {{ number_format($summary['total_price'], 0, ',', '.') }} </strong></h5>
                        <div class="d-flex justify-content-end mt-8">
                            <a href="{{ route('laporan.harian') }}" class="btn btn-label-info">Lihat Semua Laporan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            {{-- Pesanan Terbanyak --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: var(--bs-primary);">
                        <h5 class="card-title text-white">Menu Terlaris Hari Ini</h5>
                    </div>
                    <div class="card-body mt-4">
                        @if ($menuTerbanyak)
                            <h4><strong>{{ ucfirst($menuTerbanyak->menu->name) }}</strong></h4>
                            <p><strong>Total: {{ $menuTerbanyak->total_qty }} terjual</strong></p>
                        @else
                            <p class="text-muted">Belum ada pesanan.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Pesanan Terendah --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: var(--bs-primary);">
                        <h5 class="card-title text-white">Menu Terendah Hari Ini</h5>
                    </div>
                    <div class="card-body mt-4">
                        @if ($menuTerendah)
                            <h4><strong>{{ ucfirst($menuTerendah->menu->name) }}</strong></h4>
                            <p><strong>Total: {{ $menuTerendah->total_qty }} terjual</strong></p>
                        @else
                            <p class="text-muted">Belum ada pesanan.</p>
                        @endif
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
