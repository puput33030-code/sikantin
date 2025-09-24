<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Status Pesanan</title>
</head>
<body>
    <h2>Halo {{ $order->name }},</h2>

    <p>Status pesanan Anda dengan nomor <strong>#{{ $order->id }}</strong> telah siap.</p>

    <p>
        Siapkan Uang Senilai: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> untuk Membayar Pesanan Anda.
    </p>

    <p>
        @if($order->order_type == 'diambil')
            Pesanan sudah siap, Anda dapat mengambilnya sekarang😉
        @elseif($order->order_type == 'diantar')
            Pesanan Anda sudah siap, mohon tetap di tempat, pesanan sedang dalam perjalanan menuju Anda🚀
        @endif
    </p>

    <p>Terima kasih telah memesan di Aplikasi SiKantin!</p>
</body>
</html>
