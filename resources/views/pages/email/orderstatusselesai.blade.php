<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Status Pesanan</title>
</head>
<body>
    <h2>Halo {{ $order->name }},</h2>

    <p>Status pesanan Anda dengan nomor <strong>#{{ $order->id }}</strong> telah selesai.</p>

    <p>Terima kasih telah memesan di Aplikasi SiKantin, kami tunggu belanja Anda berikutnya🙌</p>
</body>
</html>
