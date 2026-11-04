<?php

namespace App\Http\Controllers;

use App\Models\DatasetKasus;
use App\Models\Pengaduan;
use App\Services\DecisionTreeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DecisionTreeController extends Controller
{
    protected DecisionTreeService $treeService;

    protected array $candidateAttributes = [
        'bentuk_perundungan',
        'frekuensi_kejadian',
        'trauma_mental',
        'luka_fisik',
        'pelaku_lebih_dari_satu',
        'konten_digital',
    ];

    public function __construct(DecisionTreeService $treeService)
    {
        $this->treeService = $treeService;
    }

    /**
     * Tampilan utama Modul Decision Tree
     */
    public function index(Request $request)
    {
        $datasetQuery = Pengaduan::whereNotNull('klasifikasi');

        if ($request->filled('sumber')) {
            $datasetQuery->where('sumber', $request->sumber);
        }

        if ($request->filled('klasifikasi')) {
            $datasetQuery->where('klasifikasi', $request->klasifikasi);
        }

        $dataset = $datasetQuery->latest()->paginate(15);
        $totalDataset = Pengaduan::whereNotNull('klasifikasi')->count();
        $totalPengaduan = Pengaduan::where('sumber', 'pengaduan')->count();

        // Ambil atau latih model Decision Tree dari cache/dataset aktif
        $allData = Pengaduan::whereNotNull('klasifikasi')->get();
        $tree = Cache::get('active_decision_tree');

        if (!$tree && $allData->count() > 0) {
            $tree = $this->treeService->buildTree($allData, $this->candidateAttributes);
            Cache::put('active_decision_tree', $tree, now()->addDays(7));
        }

        $entropyTotal = $allData->count() > 0 ? $this->treeService->entropy($allData) : 0;
        $gains = [];
        if ($allData->count() > 0) {
            foreach ($this->candidateAttributes as $attr) {
                $gains[$attr] = $this->treeService->gain($allData, $attr);
            }
            arsort($gains);
        }

        $evaluation = ($tree && $allData->count() > 0) ? $this->treeService->evaluate($allData, $tree) : null;
        $rules = $tree ? $this->treeService->extractRules($tree) : [];
        $detailedCalculation = $allData->count() > 0 ? $this->treeService->getDetailedCalculation($allData, $this->candidateAttributes) : null;

        return view('admin.metode.decision-tree', compact(
            'dataset',
            'totalDataset',
            'totalPengaduan',
            'tree',
            'entropyTotal',
            'gains',
            'evaluation',
            'rules',
            'detailedCalculation'
        ));
    }

    /**
     * Latih Ulang Pohon Keputusan (Re-train Model)
     */
    public function latih()
    {
        $allData = Pengaduan::whereNotNull('klasifikasi')->get();

        if ($allData->count() === 0) {
            return redirect()->route('admin.decision-tree.index')
                ->with('error', 'Dataset kosong! Tambahkan data historis atau sinkronisasi dari pengaduan terlebih dahulu.');
        }

        $tree = $this->treeService->buildTree($allData, $this->candidateAttributes);
        Cache::put('active_decision_tree', $tree, now()->addDays(7));

        return redirect()->route('admin.decision-tree.index')
            ->with('success', 'Model Pohon Keputusan ID3 berhasil dilatih ulang berdasarkan ' . $allData->count() . ' sampel data kasus.');
    }

    /**
     * Prediksi Kasus Baru menggunakan Pohon Keputusan
     */
    public function classify(Request $request)
    {
        $validated = $request->validate([
            'bentuk_perundungan' => 'required|in:verbal,fisik,sosial,siber,seksual',
            'frekuensi_kejadian' => 'required|in:sekali,2-3_kali,sering',
            'trauma_mental' => 'required|boolean',
            'luka_fisik' => 'required|boolean',
            'pelaku_lebih_dari_satu' => 'nullable|boolean',
            'konten_digital' => 'nullable|boolean',
        ]);

        $validated['pelaku_lebih_dari_satu'] = (bool)($request->pelaku_lebih_dari_satu ?? 0);
        $validated['konten_digital'] = (bool)($request->konten_digital ?? 0);

        // Ambil pohon dari cache atau bangun dari dataset
        $tree = Cache::get('active_decision_tree');
        if (!$tree) {
            $allData = Pengaduan::whereNotNull('klasifikasi')->get();
            if ($allData->count() > 0) {
                $tree = $this->treeService->buildTree($allData, $this->candidateAttributes);
                Cache::put('active_decision_tree', $tree, now()->addDays(7));
            }
        }

        if (!$tree) {
            return redirect()->back()->with('error', 'Pohon keputusan belum terbentuk. Silakan latih model terlebih dahulu.');
        }

        $result = $this->treeService->predict($validated, $tree);

        return view('admin.metode.classify-result', [
            'validated' => $validated,
            'klasifikasi' => $result['klasifikasi'],
            'confidence' => $result['confidence'],
            'path' => $result['path'],
        ]);
    }

    /**
     * Sinkronisasi data dari tabel Pengaduan ke Dataset Latih
     */
    public function sinkronPengaduan()
    {
        $pengaduans = Pengaduan::whereNotNull('klasifikasi')->get();

        if ($pengaduans->count() === 0) {
            return redirect()->route('admin.decision-tree.index')
                ->with('error', 'Tidak ada data pengaduan yang memiliki klasifikasi.');
        }

        $count = 0;
        foreach ($pengaduans as $p) {
            if (empty($p->kode_kasus)) {
                $p->update([
                    'kode_kasus' => 'PGD-' . str_pad($p->id_pengaduan, 3, '0', STR_PAD_LEFT)
                ]);
                $count++;
            }
        }

        // Re-train tree with newly merged dataset
        Cache::forget('active_decision_tree');

        return redirect()->route('admin.decision-tree.index')
            ->with('success', "Dataset model decision tree diperbarui dengan {$pengaduans->count()} total data kasus pengaduan & historis.");
    }

    /**
     * Unduh Template CSV untuk Dataset Historis
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="template_dataset_perundungan.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            // Header kolom
            fputcsv($handle, [
                'kode_kasus',
                'bentuk_perundungan',
                'frekuensi_kejadian',
                'trauma_mental',
                'luka_fisik',
                'pelaku_lebih_dari_satu',
                'konten_digital',
                'klasifikasi',
            ]);

            // Contoh baris petunjuk pengisian
            fputcsv($handle, ['KS-EXAMPLE1', 'verbal', 'sekali', '0', '0', '0', '0', 'ringan']);
            fputcsv($handle, ['KS-EXAMPLE2', 'verbal', 'sering', '1', '0', '1', '0', 'berat']);
            fputcsv($handle, ['KS-EXAMPLE3', 'fisik', 'sekali', '0', '1', '0', '0', 'sedang']);
            fputcsv($handle, ['KS-EXAMPLE4', 'siber', '2-3_kali', '1', '0', '0', '1', 'berat']);
            fputcsv($handle, ['KS-EXAMPLE5', 'seksual', 'sekali', '1', '0', '0', '0', 'berat']);

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Import dataset dari file CSV
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:4096',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 1000, ',');

        if (!$header || count($header) < 8) {
            fclose($handle);
            return redirect()->back()->with('error', 'Format header CSV tidak valid. Silakan gunakan template yang disediakan.');
        }

        $imported = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($row) < 8 || empty($row[1])) {
                $skipped++;
                continue;
            }

            $bentuk = strtolower(trim($row[1]));
            $frekuensi = strtolower(trim($row[2]));
            $klasifikasi = strtolower(trim($row[7]));

            // Validasi nilai enum
            if (
                !in_array($bentuk, ['verbal', 'fisik', 'sosial', 'siber', 'seksual']) ||
                !in_array($frekuensi, ['sekali', '2-3_kali', 'sering']) ||
                !in_array($klasifikasi, ['ringan', 'sedang', 'berat'])
            ) {
                $skipped++;
                continue;
            }

            Pengaduan::create([
                'id_sekolah' => 1,
                'kode_kasus' => trim($row[0]) ?: 'IMP-' . uniqid(),
                'nama_pelaku' => 'Dataset Impor',
                'nama_pelapor' => 'Arsip Impor CSV',
                'bentuk_perundungan' => $bentuk,
                'frekuensi_kejadian' => $frekuensi,
                'lokasi' => 'Lingkungan Sekolah',
                'trauma_mental' => (bool)trim($row[3]),
                'luka_fisik' => (bool)trim($row[4]),
                'pelaku_lebih_dari_satu' => (bool)trim($row[5]),
                'konten_digital' => (bool)trim($row[6]),
                'klasifikasi' => $klasifikasi,
                'deskripsi' => 'Data historis kasus diimpor dari file CSV.',
                'status' => 'history',
                'sumber' => 'history',
            ]);

            $imported++;
        }

        fclose($handle);
        Cache::forget('active_decision_tree');

        return redirect()->route('admin.decision-tree.index')
            ->with('success', "Impor berhasil: {$imported} data ditambahkan" . ($skipped > 0 ? " ({$skipped} baris dilewati karena format tidak sesuai)." : "."));
    }

    /**
     * Ekspor seluruh dataset latih ke CSV
     */
    public function exportCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="dataset_latih_perundungan_' . date('Ymd_His') . '.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'kode_kasus',
                'bentuk_perundungan',
                'frekuensi_kejadian',
                'trauma_mental',
                'luka_fisik',
                'pelaku_lebih_dari_satu',
                'konten_digital',
                'klasifikasi',
                'sumber',
            ]);

            $cases = Pengaduan::whereNotNull('klasifikasi')->get();
            foreach ($cases as $c) {
                fputcsv($handle, [
                    $c->kode_kasus,
                    $c->bentuk_perundungan,
                    $c->frekuensi_kejadian,
                    $c->trauma_mental ? '1' : '0',
                    $c->luka_fisik ? '1' : '0',
                    $c->pelaku_lebih_dari_satu ? '1' : '0',
                    $c->konten_digital ? '1' : '0',
                    $c->klasifikasi,
                    $c->sumber,
                ]);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Ekspor seluruh dataset latih ke Microsoft Excel (.xlsx)
     */
    public function exportExcel()
    {
        $cases = Pengaduan::whereNotNull('klasifikasi')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Dataset Latih ID3');

        // Headers
        $headers = [
            'A1' => 'No',
            'B1' => 'Kode Kasus',
            'C1' => 'Bentuk Perundungan',
            'D1' => 'Frekuensi Kejadian',
            'E1' => 'Trauma Mental',
            'F1' => 'Luka Fisik',
            'G1' => 'Pelaku > 1 Orang',
            'H1' => 'Konten Siber / Digital',
            'I1' => 'Tingkat Keparahan (Klasifikasi)',
            'J1' => 'Sumber Data',
        ];

        foreach ($headers as $cell => $val) {
            $sheet->setCellValue($cell, $val);
        }

        // Header style: dark indigo background, bold white text, centered, height
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
                'name' => 'Calibri',
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4338CA'], // Indigo-700
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        $rowNum = 2;
        foreach ($cases as $index => $c) {
            $sheet->setCellValue('A' . $rowNum, $index + 1);
            $sheet->setCellValue('B' . $rowNum, $c->kode_kasus);
            $sheet->setCellValue('C' . $rowNum, ucfirst($c->bentuk_perundungan));
            $sheet->setCellValue('D' . $rowNum, ucwords(str_replace('_', ' ', $c->frekuensi_kejadian)));
            $sheet->setCellValue('E' . $rowNum, $c->trauma_mental ? 'Ya (1)' : 'Tidak (0)');
            $sheet->setCellValue('F' . $rowNum, $c->luka_fisik ? 'Ya (1)' : 'Tidak (0)');
            $sheet->setCellValue('G' . $rowNum, $c->pelaku_lebih_dari_satu ? 'Kelompok (1)' : 'Tunggal (0)');
            $sheet->setCellValue('H' . $rowNum, $c->konten_digital ? 'Ada (1)' : 'Tidak (0)');
            $sheet->setCellValue('I' . $rowNum, strtoupper($c->klasifikasi));
            $sheet->setCellValue('J' . $rowNum, ucfirst($c->sumber ?? 'historis'));

            // Alternating row color
            if ($rowNum % 2 === 1) {
                $sheet->getStyle('A' . $rowNum . ':J' . $rowNum)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F8FAFC'],
                    ],
                ]);
            }

            // Classification highlight
            $badgeColor = match (strtolower($c->klasifikasi)) {
                'ringan' => 'D1FAE5', // emerald-100
                'sedang' => 'FEF3C7', // amber-100
                'berat' => 'FFE4E6',  // rose-100
                default => 'F1F5F9',
            };
            $sheet->getStyle('I' . $rowNum)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $badgeColor],
                ],
                'font' => [
                    'bold' => true,
                ],
            ]);

            $sheet->getRowDimension($rowNum)->setRowHeight(22);
            $rowNum++;
        }

        $lastRow = max(2, $rowNum - 1);

        // Grid borders
        $sheet->getStyle('A1:J' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CBD5E1'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Specific column alignments
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C2:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2:H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I2:I' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J2:J' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Auto width for columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Enable auto filter for easy sorting in Excel
        $sheet->setAutoFilter('A1:J' . $lastRow);

        $writer = new Xlsx($spreadsheet);
        $filename = 'dataset_latih_perundungan_' . date('Ymd_His') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Hapus baris dataset
     */
    public function destroyDataset($id)
    {
        Pengaduan::findOrFail($id)->delete();
        Cache::forget('active_decision_tree');

        return redirect()->route('admin.decision-tree.index')
            ->with('success', 'Data sampel berhasil dihapus dari dataset latih.');
    }

    /**
     * Reset dataset ke data Seeder standar
     */
    public function resetSeeder()
    {
        $seeder = new \Database\Seeders\DatasetKasusSeeder();
        $seeder->run();
        Cache::forget('active_decision_tree');

        return redirect()->route('admin.decision-tree.index')
            ->with('success', 'Dataset berhasil direset ke 60 data historis standar.');
    }
}
