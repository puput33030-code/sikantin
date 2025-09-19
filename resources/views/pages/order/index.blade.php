@extends('layouts.customer')

@section('title', 'Order Menu')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <h3 class="page-title mt-5" style="text-align: center;">Menu yang Tersedia Saat Ini</h3>
                    <div class="row">
                    @foreach ($menus as $menu)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 text-center">
                                <img src="{{ asset('storage/images/' . $menu->image) }}"
                                class="card-img-top" alt="{{ $menu->categories->category }}" style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $menu->name }}</h5>
                                    <p class="card-text">Harga: Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                                    <form action="{{ route('order.add', $menu->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Tambahkan ke Keranjang</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection