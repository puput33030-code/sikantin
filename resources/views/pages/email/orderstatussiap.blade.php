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
        @if($order->order_type == 'diambil')
            Anda dapat mengambilnya sekarang😉
        @elseif($order->order_type == 'diantar')
            Mohon tetap di tempat, pesanan sedang dalam perjalanan menuju Anda🚀
        @endif
    </p>

    <p>
        Siapkan uang senilai: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> untuk membayar pesanan anda.
    </p>
    <hr>
    <p>
        Mohon klik tombol di bawah ini jika pesanan telah diterima dan Anda telah melakukan pembayaran, untuk mengkonfirmasi bahwa pesanan Anda telah selesai.
    </p>
    <p>
        <a href="{{ url('/order/' . $order->id . '/done?token=' . $order->token) }}"
           style="background-color: #28a745; color: #fff; padding: 10px 20px; border-radius: 6px; text-decoration: none;">
            Konfirmasi Selesai
        </a>
    </p>
</body>
</html>
