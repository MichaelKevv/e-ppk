<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Eksekutif Kasus Perundungan - Lapora {{ $selectedYear }}</title>
    <style>
        @page {
            margin: 25px 32px 30px 32px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.4;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .header-title {
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
        }
        .header-sub {
            font-size: 9px;
            color: #475569;
        }
        .doc-title {
            text-align: center;
            margin: 10px 0 14px 0;
        }
        .doc-title h1 {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #1e3a8a;
            letter-spacing: 0.5px;
        }
        .doc-title .doc-num {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }
        .kpi-table {
            width: 100%;
            margin-bottom: 14px;
            border-collapse: collapse;
        }
        .kpi-box {
            padding: 8px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            text-align: center;
            border-radius: 4px;
        }
        .kpi-num {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
            margin-top: 2px;
        }
        .kpi-label {
            font-size: 8px;
            text-transform: uppercase;
            font-weight: bold;
            color: #64748b;
        }
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 3px;
            margin: 12px 0 6px 0;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: bold;
            padding: 5px 6px;
            border: 1px solid #cbd5e1;
            font-size: 8.5px;
            text-transform: uppercase;
            text-align: left;
        }
        table.data-table td {
            padding: 5px 6px;
            border: 1px solid #e2e8f0;
            font-size: 8.5px;
            vertical-align: top;
        }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            font-size: 7.5px;
            font-weight: bold;
            border-radius: 3px;
            text-transform: uppercase;
        }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-info { background-color: #e0e7ff; color: #3730a3; }
        .signature-table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }
        .signature-box {
            width: 45%;
            text-align: center;
            font-size: 9px;
            vertical-align: top;
        }
        .signature-line {
            margin-top: 55px;
            border-bottom: 1px solid #000;
            display: inline-block;
            width: 75%;
        }
    </style>
</head>
<body>

    <!-- Header / Kop -->
    <table class="header-table">
        <tr>
            <td style="width: 15%; text-align: left; vertical-align: middle;">
                <div style="font-size: 20px; font-weight: 900; color: #4338ca;">LAPORA</div>
                <div style="font-size: 8px; color: #6366f1; font-weight: bold;">E-PPK SISTEM</div>
            </td>
            <td style="width: 70%; text-align: center; vertical-align: middle;">
                <div class="header-title">
                    {{ $targetSekolah ? $targetSekolah->nama_sekolah : 'DINAS PENDIDIKAN & TIM PENCEGAHAN KEKERASAN (TPPK)' }}
                </div>
                <div class="header-sub">
                    {{ $targetSekolah ? 'NPSN: ' . $targetSekolah->npsn . ' | Jenjang: ' . $targetSekolah->jenjang . ' | Alamat: ' . ($targetSekolah->alamat ?? 'Wilayah Terdaftar') : 'Sistem Terpadu Penanganan dan Pencegahan Kekerasan Satuan Pendidikan' }}
                </div>
                <div class="header-sub">
                    Berdasarkan Permendikbudristek No. 46 Tahun 2023 tentang Pencegahan dan Penanganan Kekerasan di Satuan Pendidikan
                </div>
            </td>
            <td style="width: 15%; text-align: right; vertical-align: middle;">
                <div style="font-size: 8px; color: #64748b;">
                    Tanggal Cetak:<br>
                    <strong>{{ date('d/m/Y') }}</strong>
                </div>
            </td>
        </tr>
    </table>

    <!-- Document Title -->
    <div class="doc-title">
        <h1>LAPORAN EKSEKUTIF REKAPITULASI PENANGANAN KASUS PERUNDUNGAN</h1>
        <div class="doc-num">
            Periode Laporan: Tahun {{ $selectedYear }} &bull; Cakupan: {{ $targetSekolah ? $targetSekolah->nama_sekolah : 'Semua Satuan Pendidikan Terafiliasi' }}
        </div>
    </div>

    <!-- Executive KPI Boxes -->
    <table class="kpi-table">
        <tr>
            <td style="width: 20%; padding-right: 5px;">
                <div class="kpi-box">
                    <div class="kpi-label">Total Insiden</div>
                    <div class="kpi-num">{{ $totalKasus }}</div>
                </div>
            </td>
            <td style="width: 20%; padding-right: 5px;">
                <div class="kpi-box">
                    <div class="kpi-label">Kasus Selesai</div>
                    <div class="kpi-num" style="color: #166534;">{{ $kasusSelesai }}</div>
                </div>
            </td>
            <td style="width: 20%; padding-right: 5px;">
                <div class="kpi-box">
                    <div class="kpi-label">Dalam Penanganan</div>
                    <div class="kpi-num" style="color: #b45309;">{{ $kasusDiproses }}</div>
                </div>
            </td>
            <td style="width: 20%; padding-right: 5px;">
                <div class="kpi-box">
                    <div class="kpi-label">Darurat 1x24 Jam</div>
                    <div class="kpi-num" style="color: #991b1b;">{{ $kasusDarurat }}</div>
                </div>
            </td>
            <td style="width: 20%;">
                <div class="kpi-box">
                    <div class="kpi-label">Tingkat Resolusi</div>
                    <div class="kpi-num" style="color: #4338ca;">{{ $resolutionRate }}%</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Ringkasan Sebaran Modalitas Perundungan -->
    <div class="section-title">1. Distribusi Bentuk Perundungan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 20%; text-align: center;">Perundungan Verbal</th>
                <th style="width: 20%; text-align: center;">Perundungan Fisik</th>
                <th style="width: 20%; text-align: center;">Perundungan Sosial</th>
                <th style="width: 20%; text-align: center;">Perundungan Siber</th>
                <th style="width: 20%; text-align: center;">Kekerasan Seksual</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; font-size: 11px; font-weight: bold; color: #1d4ed8;">{{ $bentukCounts['verbal'] }} kasus</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold; color: #b91c1c;">{{ $bentukCounts['fisik'] }} kasus</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold; color: #b45309;">{{ $bentukCounts['sosial'] }} kasus</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold; color: #047857;">{{ $bentukCounts['siber'] }} kasus</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold; color: #7e22ce;">{{ $bentukCounts['seksual'] }} kasus</td>
            </tr>
        </tbody>
    </table>

    <!-- Daftar Berkas Kasus -->
    <div class="section-title">2. Daftar Rincian Berkas Kasus Laporan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 15%;">Kode Kasus</th>
                <th style="width: 18%;">Satuan Pendidikan</th>
                <th style="width: 12%;">Bentuk & Indikator</th>
                <th style="width: 11%; text-align: center;">Klasifikasi ID3</th>
                <th style="width: 16%;">Alur Penanganan</th>
                <th style="width: 24%;">Catatan Ringkas / Kesimpulan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cases as $idx => $case)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td>
                        <strong>{{ $case->kode_kasus ?: 'PGD-' . $case->id_pengaduan }}</strong><br>
                        <span style="color: #64748b; font-size: 7.5px;">{{ \Carbon\Carbon::parse($case->created_at)->format('d M Y') }}</span>
                    </td>
                    <td>
                        {{ $case->sekolah?->nama_sekolah ?? 'Satuan Pendidikan' }}<br>
                        <span style="color: #64748b; font-size: 7.5px;">Jenjang: {{ $case->sekolah?->jenjang ?? '-' }}</span>
                    </td>
                    <td>
                        <strong style="text-transform: capitalize;">{{ $case->bentuk_perundungan }}</strong><br>
                        @if($case->luka_fisik)
                            <span class="badge badge-danger">Luka Fisik</span>
                        @endif
                        @if($case->trauma_mental)
                            <span class="badge badge-warning">Trauma Mental</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if ($case->klasifikasi === 'berat')
                            <span class="badge badge-danger">Berat</span>
                        @elseif ($case->klasifikasi === 'sedang')
                            <span class="badge badge-warning">Sedang</span>
                        @else
                            <span class="badge badge-success">Ringan</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ in_array($case->status, ['selesai', 'ditutup']) ? 'badge-success' : 'badge-info' }}">
                            {{ $case->status_label }}
                        </span>
                        @if($case->tanggal_selesai)
                            <div style="font-size: 7.5px; color: #166534; margin-top: 2px;">
                                Selesai: {{ \Carbon\Carbon::parse($case->tanggal_selesai)->format('d/m/Y') }}
                            </div>
                        @endif
                    </td>
                    <td>
                        {{ $case->kesimpulan_kasus ?: ($case->deskripsi ? \Illuminate\Support\Str::limit($case->deskripsi, 85) : 'Dalam tahapan monitoring dan evaluasi konselor.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #64748b; padding: 15px;">
                        Tidak ada catatan berkas kasus pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Lembar Pengesahan -->
    <table class="signature-table">
        <tr>
            <td class="signature-box">
                Mengetahui,<br>
                <strong>{{ $targetSekolah ? 'Kepala ' . $targetSekolah->nama_sekolah : 'Koordinator Pengawas Satuan Pendidikan' }}</strong>
                <div class="signature-line"></div>
                <strong>{{ $targetSekolah ? ($targetSekolah->kepala_sekolah ?? 'Kepala Sekolah') : 'Drs. H. Hendra Wijaya, M.Pd' }}</strong><br>
                <span>NIP: {{ $targetSekolah ? ($targetSekolah->nip_kepala_sekolah ?? '-') : '19750812 200212 1 003' }}</span>
            </td>
            <td style="width: 10%;"></td>
            <td class="signature-box">
                Dibuat Oleh,<br>
                <strong>{{ $user->isGuruBk() ? 'Petugas Guru Bimbingan Konseling' : 'Administrator Sistem E-PPK Lapora' }}</strong>
                <div class="signature-line"></div>
                <strong>{{ $user->nama_lengkap }}</strong><br>
                <span>NIP/ID: {{ $user->guruBk?->nip ?? $user->username }}</span>
            </td>
        </tr>
    </table>

</body>
</html>
