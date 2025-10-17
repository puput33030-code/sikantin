<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Selesai</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Pesanan Selesai',
        text: 'Pesanan Anda dengan nomor #{{ $order->id }} telah selesai.',
        confirmButtonText: 'OK'
    }).then(() => {
        // Setelah klik OK, tab akan otomatis tertutup
        window.close();
    });
</script>
</body>
</html>
