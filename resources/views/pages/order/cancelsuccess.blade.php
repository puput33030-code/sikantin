<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembatalan Berhasil</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Pesanan Dibatalkan',
        text: 'Pesanan Anda dengan nomor #{{ $order->id }} telah berhasil dibatalkan.',
        confirmButtonText: 'OK'
    });
</script>
</body>
</html>
