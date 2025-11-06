<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang di Pustaka Buku</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { width: 90%; margin: auto; padding: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 25px; }
        h3 { color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h3>Halo, {{ $userData['name'] }}!</h3>
            <p>Terima kasih telah mendaftar di aplikasi Pustaka Buku.</p>
            <p>Akun Anda telah berhasil dibuat dengan detail sebagai berikut:</p>
            <ul>
                <li><strong>Nama:</strong> {{ $userData['name'] }}</li>
                <li><strong>Email:</strong> {{ $userData['email'] }}</li>
            </ul>
            <p>Silakan login ke aplikasi untuk mulai mengelola koleksi buku Anda.</p>
            <br>
            <p>Terima kasih,</p>
            <p>Tim Pustaka Buku</p>
        </div>
    </div>
</body>
</html>