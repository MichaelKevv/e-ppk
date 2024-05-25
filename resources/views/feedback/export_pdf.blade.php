<!DOCTYPE html>
<html>

<head>
    <title>Laporan Feedback</title>
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
        <h5 class="mb-2">Laporan Feedback</h5>
    </center>
    <div class="printed-date">
        Dicetak pada tanggal: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
    </div>
    <table class='table table-bordered table-striped'>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Judul Pengaduan</th>
                <th>Feedback</th>
                <th>Petugas</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $feedback)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $feedback->tb_siswa->nama }}</td>
                    <td>{{ $feedback->tb_siswa->kelas }}</td>
                    <td>{{ $feedback->tb_siswa->jurusan }}</td>
                    <td>{!! Str::limit($feedback->tb_pengaduan->judul, 50) !!}</td>
                    <td>{!! Str::limit($feedback->teks_tanggapan, 50) !!}</td>
                    <td>{{ $feedback->tb_petuga->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
