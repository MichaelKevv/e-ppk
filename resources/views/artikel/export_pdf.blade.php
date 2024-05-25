<!DOCTYPE html>
<html>

<head>
    <title>Laporan Artikel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .table th,
        .table td {
            font-size: 9pt;
        }

        .table thead th {
            color: #000;
            text-align: center;
        }

        .table tbody td {
            text-align: center;
        }

        h5 {
            font-size: 16pt;
            margin-bottom: 5px;
        }

        .table {
            margin-top: 20px;
        }

        .printed-date {
            font-size: 9pt;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <center>
        <h5 class="mb-2">Laporan Artikel</h5>
    </center>
    <div class="printed-date">
        Dicetak pada tanggal: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
    </div>
    <table class='table table-bordered table-striped'>
        <thead>
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Judul</th>
                <th>Konten</th>
                <th>Kategori</th>
                <th>Tanggal Upload</th>
                <th>Author</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $artikel)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ storage_path('app/public/foto-artikel/' . $artikel->gambar) }}" width="100px">
                    </td>
                    <td>{{ $artikel->judul }}</td>
                    <td>{!! $artikel->konten !!}</td>
                    <td>{{ $artikel->kategori }}</td>
                    <td>{{ \Carbon\Carbon::parse($artikel->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}</td>
                    <td>{{ $artikel->author }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
