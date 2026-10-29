<?php

namespace App\Http\Controllers;

use App\Models\SurveyData;
use Illuminate\Http\Request;

class TAMController extends Controller
{
    public function index()
    {
        return $this->renderTAMView(false);
    }

    public function hitung(Request $request)
    {
        return $this->renderTAMView(true);
    }

    protected function renderTAMView(bool $isRecalculated = false)
    {
        $surveys = SurveyData::all();
        $total = $surveys->count();

        // Rata-rata Skor Dimensi TAM (Skala Likert 1.00 - 5.00)
        $pu = $total > 0 ? round((float)$surveys->avg('perceived_usefulness'), 2) : 0.0;
        $peou = $total > 0 ? round((float)$surveys->avg('perceived_ease_of_use'), 2) : 0.0;
        $bi = $total > 0 ? round((float)$surveys->avg('behavioral_intention_to_use'), 2) : 0.0;

        // Rata-rata Gabungan & Persentase Penerimaan Sistem (%)
        $overall = $total > 0 ? round(($pu + $peou + $bi) / 3, 2) : 0.0;
        $acceptancePct = round(($overall / 5) * 100, 1);

        // Kategori Interpretasi Penerimaan TAM (Menurut Davis / Likert standard)
        $kategori = match (true) {
            $acceptancePct >= 80 => [
                'label' => 'Sangat Diterima (Tinggi)',
                'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                'color' => 'emerald',
                'keterangan' => 'Pengguna menilai Lapora sangat bermanfaat, intuitif, dan memiliki komitmen penggunaan jangka panjang yang sangat kuat.'
            ],
            $acceptancePct >= 65 => [
                'label' => 'Diterima dengan Baik',
                'badge' => 'bg-blue-100 text-blue-800 border-blue-300',
                'color' => 'blue',
                'keterangan' => 'Sistem Lapora dinilai bermanfaat dan mudah digunakan dalam operasional sehari-hari di sekolah.'
            ],
            $acceptancePct >= 50 => [
                'label' => 'Cukup Diterima (Moderat)',
                'badge' => 'bg-amber-100 text-amber-800 border-amber-300',
                'color' => 'amber',
                'keterangan' => 'Sistem dapat diterima, namun diperlukan pelatihan tambahan serta penyederhanaan beberapa alur pelaporan.'
            ],
            default => [
                'label' => 'Perlu Peningkatan',
                'badge' => 'bg-rose-100 text-rose-800 border-rose-300',
                'color' => 'rose',
                'keterangan' => 'Sistem memerlukan evaluasi antarmuka dan perbaikan proses bimbingan konseling.'
            ],
        };

        // Ekstraksi nilai numerik untuk analisis korelasi
        $puScores = $surveys->pluck('perceived_usefulness')->filter()->map(fn($v) => (float)$v)->values()->toArray();
        $peouScores = $surveys->pluck('perceived_ease_of_use')->filter()->map(fn($v) => (float)$v)->values()->toArray();
        $biScores = $surveys->pluck('behavioral_intention_to_use')->filter()->map(fn($v) => (float)$v)->values()->toArray();

        // Hitung Korelasi Pearson (r) antar-konstruk TAM
        $r_peou_pu = $this->calculateCorrelation($peouScores, $puScores);
        $r_pu_bi = $this->calculateCorrelation($puScores, $biScores);
        $r_peou_bi = $this->calculateCorrelation($peouScores, $biScores);

        $hasil = [
            'PU' => $pu,
            'PEOU' => $peou,
            'BI' => $bi,
            'overall' => $overall,
            'acceptancePct' => $acceptancePct,
            'total' => $total,
            'kategori' => $kategori,
            'r_peou_pu' => $r_peou_pu,
            'r_pu_bi' => $r_pu_bi,
            'r_peou_bi' => $r_peou_bi,
            'radarData' => [
                'labels' => ['Perceived Usefulness (PU)', 'Perceived Ease of Use (PEOU)', 'Behavioral Intention (BI)'],
                'scores' => [$pu, $peou, $bi],
            ],
        ];

        return view('admin.metode.tam', compact('hasil', 'isRecalculated'));
    }

    /**
     * Hitung Koefisien Korelasi Pearson (r) antara dua variabel sampel
     */
    protected function calculateCorrelation(array $x, array $y): float
    {
        $n = count($x);
        if ($n < 2 || count($y) !== $n) {
            return 0.0;
        }

        $meanX = array_sum($x) / $n;
        $meanY = array_sum($y) / $n;

        $numerator = 0.0;
        $denomX = 0.0;
        $denomY = 0.0;

        for ($i = 0; $i < $n; $i++) {
            $diffX = $x[$i] - $meanX;
            $diffY = $y[$i] - $meanY;
            $numerator += ($diffX * $diffY);
            $denomX += pow($diffX, 2);
            $denomY += pow($diffY, 2);
        }

        $denominator = sqrt($denomX * $denomY);
        if ($denominator == 0.0) {
            return 0.0;
        }

        return round($numerator / $denominator, 3);
    }
}

