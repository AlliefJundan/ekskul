<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi - {{ $ekskul->nama_ekskul }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Rekap Absensi : {{ $ekskul->nama_ekskul }}</h1>
    <p>Bulan: {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapAbsen as $user)
                <tr>
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->absensi->where('kehadiran', 'hadir')->count() }}</td>
                    <td>{{ $user->absensi->where('kehadiran', 'izin')->count() }}</td>
                    <td>{{ $user->absensi->where('kehadiran', 'sakit')->count() }}</td>
                    <td>{{ $user->absensi->where('kehadiran', 'alpa')->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
