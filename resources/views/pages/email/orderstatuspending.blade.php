<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>StatusPesanan</title>
</head>
<body>
    <h2>Halo {{ $order->name }}!</h2>

    <p>Status pesanan Anda dengan nomor <strong>#{{ $order->id }}</strong> sedang menunggu konfirmasi dari pihak kantin.</p>

    <p>Jika Anda ingin membatalkan pesanan ini, silakan klik tombol di bawah:</p><br>

    <p>
        <a href="{{ url('/order/' . $order->id . '/cancel?token=' . $order->token) }}"
           style="background-color: #dc3545; color: #fff; padding: 10px 20px; border-radius: 6px; text-decoration: none;">
            Batalkan Pesanan
        </a>
    </p>

    <hr>

    <p>Pastikan Anda hanya membatalkan pesanan jika belum diproses oleh kasir.</p>
    <p>Tetap pantau email dari kami untuk terus mendapatkan informasi tentang status pesanan Anda.</p>
    
</body>
</html>
