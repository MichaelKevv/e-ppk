<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class DecisionTreeController extends Controller
{
    public function index()
    {
        $data = Pengaduan::all();
        return view('admin.metode.decision-tree', compact('data'));
    }

    public function proses()
    {
        $data = Pengaduan::all();

        $entropyTotal = $this->entropy($data);
        $gainList = [
            'Bentuk Perundungan' => $this->gain($data, 'bentuk_perundungan'),
            'Frekuensi Kejadian' => $this->gain($data, 'frekuensi_kejadian'),
            'Trauma Mental' => $this->gain($data, 'trauma_mental'),
            'Luka Fisik' => $this->gain($data, 'luka_fisik'),
        ];

        arsort($gainList);
        $rootNode = array_key_first($gainList);

        return view('admin.metode.decision-tree', compact('data', 'entropyTotal', 'gainList', 'rootNode'));
    }

    // === Fungsi Prediksi Otomatis ===
    public function classify(Request $request)
    {
        $validated = $request->validate([
            'bentuk_perundungan' => 'required',
            'frekuensi_kejadian' => 'required',
            'trauma_mental' => 'required|boolean',
            'luka_fisik' => 'required|boolean',
        ]);

        $klasifikasi = '';

        if (
            $validated['bentuk_perundungan'] == 'fisik' ||
            $validated['bentuk_perundungan'] == 'seksual' ||
            $validated['trauma_mental'] == true ||
            $validated['luka_fisik'] == true
        ) {
            $klasifikasi = 'Berat';
        } elseif (
            $validated['bentuk_perundungan'] == 'verbal' &&
            $validated['frekuensi_kejadian'] == 'sering'
        ) {
            $klasifikasi = 'Sedang';
        } else {
            $klasifikasi = 'Ringan';
        }

        return view('admin.metode.classify-result', compact('validated', 'klasifikasi'));
    }

    // === Fungsi Hitung Entropi ===
    private function entropy($data)
    {
        $total = $data->count();
        if ($total == 0) return 0;

        $counts = $data->groupBy('klasifikasi')->map->count();
        $entropy = 0;

        foreach ($counts as $count) {
            $p = $count / $total;
            $entropy -= $p * log($p, 2);
        }

        return round($entropy, 4);
    }

    // === Fungsi Hitung Gain ===
    private function gain($data, $atribut)
    {
        $entropyTotal = $this->entropy($data);
        $values = $data->groupBy($atribut);
        $weightedEntropy = 0;

        foreach ($values as $subset) {
            $proporsi = $subset->count() / $data->count();
            $weightedEntropy += $proporsi * $this->entropy($subset);
        }

        $gain = $entropyTotal - $weightedEntropy;
        return round($gain, 4);
    }
}
