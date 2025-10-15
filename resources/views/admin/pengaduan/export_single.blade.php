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

        h5 {
            font-size: 16pt;
        }

        .printed-date,
        p {
            font-size: 10pt;
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
        <u style="text-transform: uppercase;"><strong>Laporan Pengaduan</strong></u>
        <p><strong>NOMOR : {{ $pengaduan->no_surat }}</strong></p>
    </center>
    <p>Tanggal Pengaduan: {{ \Carbon\Carbon::parse($pengaduan->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}</p>
    <p>Dilaporkan oleh : {{ $pengaduan->tb_siswa->nama }}</p>
    <p>Kelas : {{ $pengaduan->tb_siswa->kelas }}</p>
    <p>Judul Pengaduan : {{ $pengaduan->judul }}</p>
    <p>Deskripsi :</p>
    {!! $pengaduan->deskripsi !!}
    @if ($pengaduan->foto)
        <p>Foto Pengaduan</p>
        <center>
            <img src="{{ storage_path('app/public/foto-pengaduan/' . $pengaduan->foto) }}" width="500px">
        </center>
    @endif
</body>

</html>
