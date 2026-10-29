<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Berita Acara & Rekam Jejak Kasus - {{ $pengaduan->kode_kasus ?: 'Kasus #' . $pengaduan->id_pengaduan }}</title>
    <style>
        @page {
            margin: 28px 36px 36px 36px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            line-height: 1.45;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .header-title {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header-sub {
            font-size: 10px;
            color: #475569;
        }
        .doc-title {
            text-align: center;
            margin: 12px 0 16px 0;
        }
        .doc-title h1 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #1e3a8a;
            letter-spacing: 0.8px;
        }
        .doc-title .doc-num {
            font-size: 10px;
            color: #64748b;
            margin-top: 3px;
        }
        .badge {
            display: inline-block;
            padding: 3px 7px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-info { background-color: #e0e7ff; color: #3730a3; }
        .badge-secondary { background-color: #f1f5f9; color: #475569; }

        .section-heading {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f8fafc;
            border-left: 3px solid #2563eb;
            padding: 4px 8px;
            margin: 12px 0 6px 0;
            color: #1e293b;
        }

        table.info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.info-grid td {
            padding: 4px 6px;
            vertical-align: top;
            font-size: 10.5px;
        }
        table.info-grid td.label {
            width: 25%;
            font-weight: bold;
            color: #475569;
            background-color: #fcfcfd;
            border-bottom: 1px solid #f1f5f9;
        }
        table.info-grid td.val {
            width: 75%;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 12px;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 6px 8px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }
        table.data-table td {
            padding: 5px 8px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
            vertical-align: top;
        }

        .box-desc {
            background-color: #fafaf9;
            border: 1px solid #e7e5e4;
            padding: 8px 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 10.5px;
            line-height: 1.5;
        }

        .signatures {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .signatures td {
            width: 50%;
            vertical-align: top;
            text-align: center;
            font-size: 10px;
        }
        .signature-space {
            height: 55px;
        }
    </style>
</head>
<body>

    <!-- Header Instansi / Sekolah -->
    <table class="header-table">
        <tr>
            <td style="width: 12%; text-align: left; vertical-align: middle;">
                <div style="font-size: 22px; font-weight: 900; color: #2563eb; letter-spacing: -1px;">LAPORA</div>
            </td>
            <td style="text-align: left; vertical-align: middle; padding-left: 8px;">
                <div class="header-title">
                    {{ $pengaduan->sekolah?->nama_sekolah ?? 'SISTEM INFORMASI LAPORA' }}
                </div>
                <div class="header-sub">
                    NPSN: {{ $pengaduan->sekolah?->npsn ?? '-' }} | Jenjang: {{ $pengaduan->sekolah?->jenjang ?? 'Sekolah' }} | 
                    Alamat: {{ $pengaduan->sekolah?->alamat ?? 'Wilayah Terdaftar' }}
                </div>
            </td>
            <td style="width: 25%; text-align: right; vertical-align: middle;">
                <span class="badge {{ $pengaduan->klasifikasi == 'berat' ? 'badge-danger' : ($pengaduan->klasifikasi == 'sedang' ? 'badge-warning' : 'badge-success') }}">
                    Tingkat: {{ ucfirst($pengaduan->klasifikasi ?? 'Sedang') }}
                </span>
            </td>
        </tr>
    </table>

    <!-- Judul Dokumen -->
    <div class="doc-title">
        <h1>BERITA ACARA & REKAM JEJAK PENANGANAN KASUS</h1>
        <div class="doc-num">Nomor Berkas: {{ $pengaduan->kode_kasus ?: 'KASUS-' . str_pad($pengaduan->id_pengaduan, 5, '0', STR_PAD_LEFT) }}</div>
    </div>

    <!-- Data Identitas Kasus -->
    <div class="section-heading">I. IDENTITAS KASUS & PELAPOR</div>
    <table class="info-grid">
        <tr>
            <td class="label">Kode Kasus</td>
            <td class="val"><strong>{{ $pengaduan->kode_kasus ?: '-' }}</strong></td>
        </tr>
        <tr>
            <td class="label">Tanggal Lapor / Catat</td>
            <td class="val">{{ \Carbon\Carbon::parse($pengaduan->created_at)->isoFormat('dddd, D MMMM YYYY - HH:mm') }} WIB</td>
        </tr>
        <tr>
            <td class="label">Pelapor / Korban</td>
            <td class="val">
                <strong>{{ $pengaduan->siswa?->nama ?? ($pengaduan->user?->name ?? 'Anonim / Terproteksi') }}</strong>
                @if($pengaduan->siswa?->kelas)
                    (Kelas: {{ $pengaduan->siswa->kelas }})
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Sekolah Terafiliasi</td>
            <td class="val">{{ $pengaduan->sekolah?->nama_sekolah ?? 'Belum Ditentukan' }}</td>
        </tr>
        <tr>
            <td class="label">Terduga Pelaku</td>
            <td class="val">{{ $pengaduan->nama_pelaku ?? 'Dalam Penyelidikan' }}</td>
        </tr>
        <tr>
            <td class="label">Status Tahap Saat Ini</td>
            <td class="val">
                <span class="badge badge-info">{{ $pengaduan->status_label }}</span>
                (Progress: {{ $pengaduan->progress_percent }}%)
            </td>
        </tr>
    </table>

    <!-- Indikator & Klasifikasi Sistem -->
    <div class="section-heading">II. INDIKATOR KLINIS & ANALISIS SISTEM (ID3)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Bentuk Perundungan</th>
                <th>Frekuensi</th>
                <th>Luka Fisik</th>
                <th>Trauma Mental</th>
                <th>Pelaku Ganda</th>
                <th>Bukti Digital</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>{{ ucfirst($pengaduan->bentuk_perundungan ?? 'verbal') }}</strong></td>
                <td>{{ ucfirst($pengaduan->frekuensi_kejadian ?? 'sering') }}</td>
                <td>{{ $pengaduan->luka_fisik ? 'YA (Ada Bukti)' : 'TIDAK' }}</td>
                <td>{{ $pengaduan->trauma_mental ? 'YA (Terindikasi)' : 'TIDAK' }}</td>
                <td>{{ $pengaduan->pelaku_lebih_dari_satu ? 'YA (>1 Orang)' : 'Tunggal' }}</td>
                <td>{{ $pengaduan->konten_digital ? 'YA (Digital)' : 'TIDAK' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Deskripsi / Kronologi Kejadian -->
    <div class="section-heading">III. KRONOLOGI & DESKRIPSI KEJADIAN</div>
    <div class="box-desc">
        {!! nl2br(e($pengaduan->deskripsi ?: 'Tidak ada uraian narasi tertulis atau bersumber dari rekaman data historis komputasi.')) !!}
    </div>

    <!-- Rekam Jejak Tindakan & Konseling -->
    <div class="section-heading">IV. AUDIT TRAIL & REKAM JEJAK PENANGANAN (GURU BK / TIM SATGAS)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 18%;">Waktu & Petugas</th>
                <th style="width: 16%;">Tahapan</th>
                <th style="width: 26%;">Tindakan / Sesi</th>
                <th style="width: 40%;">Catatan & Rekomendasi Lanjutan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengaduan->riwayatTindakan as $tindakan)
                <tr>
                    <td>
                        <strong>{{ \Carbon\Carbon::parse($tindakan->created_at)->format('d/m/Y H:i') }}</strong><br>
                        <span style="color: #64748b; font-size: 9px;">{{ $tindakan->nama_petugas }} ({{ $tindakan->peran_petugas }})</span>
                    </td>
                    <td>
                        <span class="badge badge-secondary">{{ ucfirst($tindakan->status_tahap) }}</span>
                    </td>
                    <td>
                        <strong>{{ $tindakan->judul_tindakan }}</strong>
                    </td>
                    <td>
                        {{ $tindakan->catatan }}
                        @if($tindakan->rekomendasi)
                            <br><em style="color: #2563eb; font-size: 9px;">Rekomendasi: {{ $tindakan->rekomendasi }}</em>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #94a3b8; padding: 12px;">
                        <em>Belum ada catatan tahapan investigasi, konseling, atau mediasi yang terekam pada berkas ini.</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($pengaduan->kesimpulan_kasus)
        <div class="section-heading">V. KESIMPULAN & PENYELESAIAN AKHIR KASUS</div>
        <div class="box-desc" style="background-color: #f0fdf4; border-color: #bbf7d0;">
            <strong>Catatan Penyelesaian:</strong><br>
            {{ $pengaduan->kesimpulan_kasus }}
            @if($pengaduan->tanggal_selesai)
                <br><span style="font-size: 9px; color: #166534;">Kasus resmi ditutup pada: {{ \Carbon\Carbon::parse($pengaduan->tanggal_selesai)->isoFormat('D MMMM YYYY') }}</span>
            @endif
        </div>
    @endif

    <!-- Lembar Pengesahan -->
    <table class="signatures">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Kepala Sekolah</strong>
                <div class="signature-space"></div>
                <strong>{{ $pengaduan->sekolah?->kepala_sekolah ?? '(..................................................)' }}</strong><br>
                NIP. {{ $pengaduan->sekolah?->nip_kepala_sekolah ?? '-' }}
            </td>
            <td>
                Dicatat & Diverifikasi oleh,<br>
                <strong>Guru Bimbingan Konseling / Satgas PPK</strong>
                <div class="signature-space"></div>
                <strong>{{ Auth::user()->name ?? 'Guru Pembimbing BK' }}</strong><br>
                Petugas Verifikator Kasus
            </td>
        </tr>
    </table>

</body>
</html>
