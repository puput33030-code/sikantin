@extends('layouts.customer')

@section('title', 'Order Menu')

@section('content')
    <div id="main-content">
        <div class="container">
            <div class="col-md-12">
                <h2 class="text-center mt-3" style="color: #dc3545">Selamat Datang di Aplikasi SiKantin!</h2>
                <h3 class="page-title mt-5 text-center">Berikut Daftar Menu yang Tersedia Saat Ini</h3>
                <!-- Tombol Filter Kategori -->
                <div class="d-flex justify-content-center flex-wrap gap-2 mt-3 mb-8">
                    <a href="{{ route('order.index') }}"
                        class="btn {{ request('category') ? 'btn-outline-danger' : 'btn-danger' }}">
                        Semua
                    </a>

                    @foreach ($categories as $category)
                        <a href="{{ route('order.index', ['category' => $category->id]) }}"
                            class="btn {{ request('category') == $category->id ? 'btn-danger' : 'btn-outline-danger' }}">
                            {{ $category->category }}
                        </a>
                    @endforeach
                </div>

                <!-- Form Pencarian -->
                <div class="d-flex justify-content-between align-items-center mb-8 flex-wrap">
                    <form action="{{ route('order.index') }}" method="GET" class="d-flex align-items-center mb-2 mb-md-0">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <input type="text" name="search" class="form-control me-2" style="width: 800px;"
                            placeholder="Cari menu..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-danger me-2">Cari</button>
                    </form>
                    <div class="d-flex align-items-center">

                        {{-- Tombol Riwayat Pesanan --}}
                        <a href="{{ route('riwayat.form') }}" class="btn btn-outline-danger me-2">
                            <span class="ti ti-history me-1"></span> Riwayat
                        </a>

                        {{-- Tombol Keranjang --}}
                        <a href="{{ route('order.cart') }}" class="btn btn-danger position-relative">
                            <span class="ti ti-shopping-cart me-1"></span>
                            @if ($cartCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                    </div>
                </div>
                <div class="row">
                    @if ($menus->isNotEmpty())
                        @foreach ($menus as $menu)
                            <div class="col-md-3 mb-4">
                                <div class="card h-100 text-center">
                                    <img src="{{ asset('storage/images/' . $menu->image) }}" class="card-img-top"
                                        alt="{{ $menu->categories->category }}" style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ ucfirst($menu->name) }}</h5>
                                        <p class="card-text" style="color: rgb(197, 128, 0)">Harga:
                                            Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                                        @if ($menu->stock > 0)
                                            <form action="{{ route('order.add', $menu->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-keranjang"
                                                    id="btnKeranjang">
                                                    <span class="text">Tambah ke Keranjang</span>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary" disabled>Habis</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @if (!empty(request('search')))
                            <div class="text-center mt-5">
                                <h5>
                                    Tidak ada menu yang cocok dengan pencarian
                                    "<strong>{{ request('search') }}</strong>"
                                </h5>
                            </div>
                        @else
                            <div class="text-center mt-5">
                                <h5>Belum ada menu yang tersedia saat ini.</h5>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ Session::get('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endpush
@push('styles')
    <style>
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .card img {
            border-radius: 10px;
        }

        .card-body h5 {
            font-weight: 600;
            margin-top: 10px;
        }

        .btn-danger {
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .btn-danger:hover {
            background-color: #ff3c3c;
            transform: scale(1.05);
        }

        .btn-keranjang {
            position: relative;
        }

        .btn-keranjang.added::after {
            content: '✓ Ditambahkan!';
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 1;
            font-weight: 600;
            animation: appear 0.5s ease-in forwards;
        }

        .btn-keranjang.added .text {
            visibility: hidden;
            /* sembunyikan teks tanpa mengubah ukuran tombol */
        }

        @keyframes appear {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(-50%);
            }
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ambil semua tombol keranjang
            const buttons = document.querySelectorAll('.btn-keranjang');

            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    // jika tombol berada di dalam form, cegah submit sementara
                    const form = btn.closest('form');
                    if (form) e.preventDefault();

                    // tambahkan class untuk memicu CSS ::after
                    btn.classList.add('added');

                    // hapus class setelah 2 detik (sesuaikan jika mau tetap)
                    setTimeout(() => {
                        btn.classList.remove('added');

                        // lalu submit form (jika memang ada)
                        if (form) form.submit();
                    }, 2000);
                });
            });
        });
    </script>
@endpush
