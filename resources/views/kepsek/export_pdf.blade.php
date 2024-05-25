<!DOCTYPE html>
<html>

<head>
    <title>Laporan Kepala Sekolah</title>
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
        <h5 class="mb-2">Laporan Kepala Sekolah</h5>
    </center>
    <div class="printed-date">
        Dicetak pada tanggal: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
    </div>
    <table class='table table-bordered table-striped'>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Gender</th>
                <th>Alamat</th>
                <th>Nomor Telepon</th>
                <th>Username</th>
                <th>Email</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $kepsek)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kepsek->nama }}</td>
                    <td>{{ $kepsek->gender }}</td>
                    <td>{{ $kepsek->alamat }}</td>
                    <td>{{ $kepsek->no_telp }}</td>
                    <td>{{ $kepsek->tb_pengguna->username }}</td>
                    <td>{{ $kepsek->tb_pengguna->email }}</td>
                    <td>
                        <img src="{{ storage_path('app/public/foto-kepsek/' . $kepsek->foto) }}" width="100px">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
