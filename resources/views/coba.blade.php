<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello, world!</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body>
    <h1>Hello, world!</h1>

    <!-- Perbaikan: Tambahkan ID pada select -->
    <select id="selectpem" class="form-select" aria-label="Default select example">
        <option value="">Pilih Pembina</option>
        <option value="1">Budi Santoso</option>
        <option value="2">Siti Aminah</option>
    </select>

    <!-- jQuery (Wajib sebelum Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Inisialisasi Select2 -->
    <script>
        $(document).ready(function () {
            $("#selectpem").select2({
                placeholder: "Pilih Pembina",
                allowClear: true
            });
        });
    </script>
</body>
</html>
    