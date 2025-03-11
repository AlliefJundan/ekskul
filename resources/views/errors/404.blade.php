<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f8f9fa;
        }

        h1 {
            font-size: 50px;
            color: #dc3545;
        }

        p {
            font-size: 20px;
            color: #6c757d;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>404</h1>
    <p>Oops! Halaman yang kamu cari tidak ditemukan.</p>
    <a href="{{ route('dashboard_admin') }}">Kembali ke Dashboard</a>
</body>

</html>
