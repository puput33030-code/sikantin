@extends('layouts.customer')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 text-center">Cek Riwayat Pesanan Anda</h3>

    <form action="{{ route('riwayat.hasil') }}" method="POST" class="w-50 mx-auto">
        @csrf
        
        <div class="form-group mb-3">
            <label>Email Anda:</label>
            <input type="email" name="email" class="form-control" required placeholder="Masukkan email yang digunakan saat memesan">
        </div>

        <button class="btn btn-primary w-100">Lihat Riwayat</button>
    </form>
</div>
@endsection