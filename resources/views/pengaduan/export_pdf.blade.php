<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengaduan</title>
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

        .kop-surat hr {
            border: 0;
            border-top: 1px solid black;
            margin: 5px 0;
        }

        .kop-surat .line {
            border-bottom: 2px solid black;
            margin-top: 2px;
            margin-bottom: 15px;
        }
        .img-fluid {
  max-width: 100%;
  height: auto;
}
    </style>
</head>

<body>
    <div class="kop-surat">
        <img src="{{ public_path('images/kop_surat.png') }}" class="img-fluid">
        <hr>
        <div class="line"></div>
    </div>
    <center>
        <h5 class="mb-5">Laporan Pengaduan</h5>
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
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $pengaduan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pengaduan->tb_siswa->nama }}</td>
                    <td>{{ $pengaduan->tb_siswa->kelas }}</td>
                    <td>{{ $pengaduan->tb_siswa->jurusan }}</td>
                    <td>{{ $pengaduan->judul }}</td>
                    <td>{!! $pengaduan->deskripsi !!}</td>
                    <td>{{ \Carbon\Carbon::parse($pengaduan->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}</td>
                    <td>{{ $pengaduan->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
