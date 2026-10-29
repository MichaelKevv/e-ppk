<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Feedback &amp; Konseling Kasus - Lapora</title>
    <style type="text/css">
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            margin: 20px 25px;
            font-size: 9pt;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
            color: #0f172a;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 4px 0 0 0;
            font-size: 8.5pt;
            color: #64748b;
        }

        .meta-info {
            margin-bottom: 15px;
            font-size: 8.5pt;
            color: #475569;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: 1px solid #cbd5e1;
            padding: 8px 6px;
            text-align: left;
        }

        td {
            border: 1px solid #e2e8f0;
            padding: 8px 6px;
            font-size: 8pt;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 7.5pt;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 8.5pt;
            color: #64748b;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Riwayat Feedback &amp; Konseling</h2>
        <p>Sistem Pengaduan &amp; Perlindungan Kekerasan Siswa (Lapora) &bull; Dokumen Resmi</p>
    </div>

    <div class="meta-info">
        <strong>Dicetak Pada:</strong> {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB &bull; 
        <strong>Total Catatan:</strong> {{ count($data) }} Tanggapan
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25px; text-align: center;">#</th>
                <th style="width: 110px;">Siswa / Korban</th>
                <th style="width: 130px;">Kasus Pengaduan</th>
                <th>Isi Feedback / Catatan Konseling</th>
                <th style="width: 110px;">Pemberi Feedback</th>
                <th style="width: 85px; text-align: center;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $feedback)
                @php
                    $p = $feedback->pengaduan;
                    $namaSiswa = $p?->siswa?->nama ?? optional($p?->user?->siswas)->first()?->nama ?? '-';
                    $kelasSiswa = $p?->siswa?->kelas ?? optional($p?->user?->siswas)->first()?->kelas ?? '-';
                    $judulKasus = $p ? (ucfirst($p->bentuk_perundungan ?? 'Kasus') . ' di ' . ($p->lokasi ?? '-')) : 'Kasus Terhapus';
                    $u = $feedback->user;
                    $pengirim = $u ? ($u->name ?? $u->username) : 'Petugas';
                    $rolePengirim = ucfirst($u?->role ?? 'Admin');
                @endphp
                <tr>
                    <td style="text-align: center; color: #64748b;">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $namaSiswa }}</strong><br>
                        <span style="color: #64748b; font-size: 7.5pt;">Kelas: {{ $kelasSiswa }}</span>
                    </td>
                    <td>
                        <strong>{{ $judulKasus }}</strong><br>
                        @if ($p && $p->status)
                            <span class="badge">{{ $p->status }}</span>
                        @endif
                    </td>
                    <td style="color: #334155;">
                        {!! nl2br(e(Str::limit(strip_tags($feedback->isi_tanggapan), 250))) !!}
                    </td>
                    <td>
                        <strong>{{ $pengirim }}</strong><br>
                        <span style="color: #64748b; font-size: 7.5pt;">Peran: {{ $rolePengirim }}</span>
                    </td>
                    <td style="text-align: center; color: #64748b; font-size: 7.5pt;">
                        {{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('D MMM YYYY') }}<br>
                        {{ \Carbon\Carbon::parse($feedback->created_at)->format('H:i') }} WIB
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #94a3b8; padding: 20px;">
                        Tidak ada catatan feedback dalam sistem.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak otomatis oleh Sistem Lapora &bull; Halaman Arsip Konseling</p>
    </div>

</body>
</html>
