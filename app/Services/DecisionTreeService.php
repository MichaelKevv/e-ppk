<?php

namespace App\Services;

use Illuminate\Support\Collection;

class DecisionTreeService
{
    protected array $attributeLabels = [
        'bentuk_perundungan' => 'Bentuk Perundungan',
        'frekuensi_kejadian' => 'Frekuensi Kejadian',
        'trauma_mental' => 'Trauma Mental',
        'luka_fisik' => 'Luka Fisik',
        'pelaku_lebih_dari_satu' => 'Pelaku > 1 Orang',
        'konten_digital' => 'Konten Digital (Bukti Siber)',
    ];

    /**
     * Hitung Entropi himpunan data
     */
    public function entropy(Collection $data, string $targetAttr = 'klasifikasi'): float
    {
        $total = $data->count();
        if ($total === 0) {
            return 0.0;
        }

        $counts = $data->groupBy($targetAttr)->map->count();
        $entropy = 0.0;

        foreach ($counts as $count) {
            $p = $count / $total;
            if ($p > 0) {
                $entropy -= $p * log($p, 2);
            }
        }

        return round($entropy, 4);
    }

    /**
     * Hitung Information Gain untuk suatu atribut
     */
    public function gain(Collection $data, string $attribute, string $targetAttr = 'klasifikasi'): float
    {
        $total = $data->count();
        if ($total === 0) {
            return 0.0;
        }

        $entropyTotal = $this->entropy($data, $targetAttr);
        $groups = $data->groupBy(function ($item) use ($attribute) {
            return (string)($item->$attribute ?? $item[$attribute] ?? '');
        });

        $weightedEntropy = 0.0;
        foreach ($groups as $subset) {
            $proporsi = $subset->count() / $total;
            $weightedEntropy += $proporsi * $this->entropy($subset, $targetAttr);
        }

        $gain = $entropyTotal - $weightedEntropy;
        return round($gain, 4);
    }

    /**
     * Bangun Pohon Keputusan ID3 secara rekursif
     */
    public function buildTree(
        Collection $data,
        array $attributes,
        string $targetAttr = 'klasifikasi',
        int $depth = 0,
        int $maxDepth = 6
    ): array {
        $total = $data->count();
        $targetCounts = $data->groupBy($targetAttr)->map->count()->toArray();

        // 1. Kasus jika data kosong
        if ($total === 0) {
            return [
                'type' => 'leaf',
                'label' => 'ringan',
                'total_samples' => 0,
                'confidence' => 0,
                'distribution' => [],
            ];
        }

        // Tentukan kelas mayoritas saat ini
        arsort($targetCounts);
        $majorityClass = array_key_first($targetCounts);

        // 2. Base Case: Seluruh sampel memiliki target kelas yang sama (Murni / Pure Leaf)
        if (count($targetCounts) === 1) {
            return [
                'type' => 'leaf',
                'label' => $majorityClass,
                'total_samples' => $total,
                'confidence' => 100.0,
                'distribution' => $targetCounts,
            ];
        }

        // 3. Base Case: Tidak ada lagi atribut yang tersisa atau sudah mencapai batas kedalaman (Max Depth)
        if (empty($attributes) || $depth >= $maxDepth) {
            $confidence = round(($targetCounts[$majorityClass] / $total) * 100, 1);
            return [
                'type' => 'leaf',
                'label' => $majorityClass,
                'total_samples' => $total,
                'confidence' => $confidence,
                'distribution' => $targetCounts,
            ];
        }

        // 4. Hitung Gain untuk seluruh atribut yang tersisa
        $gains = [];
        foreach ($attributes as $attr) {
            $gains[$attr] = $this->gain($data, $attr, $targetAttr);
        }

        arsort($gains);
        $bestAttr = array_key_first($gains);
        $bestGain = $gains[$bestAttr];

        // Jika Gain terbaik <= 0, tidak ada peningkatan informasi, buat leaf
        if ($bestGain <= 0.0001) {
            $confidence = round(($targetCounts[$majorityClass] / $total) * 100, 1);
            return [
                'type' => 'leaf',
                'label' => $majorityClass,
                'total_samples' => $total,
                'confidence' => $confidence,
                'distribution' => $targetCounts,
            ];
        }

        // 5. Buat Node Percabangan untuk atribut terbaik
        $remainingAttributes = array_values(array_diff($attributes, [$bestAttr]));
        $subsets = $data->groupBy(function ($item) use ($bestAttr) {
            $val = is_array($item) ? ($item[$bestAttr] ?? '') : ($item->$bestAttr ?? '');
            if (is_bool($val)) {
                return $val ? '1' : '0';
            }
            if ($val === 1 || $val === '1') {
                return '1';
            }
            if ($val === 0 || $val === '0') {
                return '0';
            }
            return (string)$val;
        });

        $branches = [];
        foreach ($subsets as $value => $subset) {
            $branches[$value] = $this->buildTree(
                $subset,
                $remainingAttributes,
                $targetAttr,
                $depth + 1,
                $maxDepth
            );
        }

        return [
            'type' => 'node',
            'attribute' => $bestAttr,
            'attribute_label' => $this->attributeLabels[$bestAttr] ?? ucfirst(str_replace('_', ' ', $bestAttr)),
            'gain' => $bestGain,
            'entropy' => $this->entropy($data, $targetAttr),
            'total_samples' => $total,
            'distribution' => $targetCounts,
            'majority_class' => $majorityClass,
            'branches' => $branches,
        ];
    }

    /**
     * Prediksi sampel menggunakan pohon keputusan yang sudah dilatih
     */
    public function predict(array $sample, array $tree, array $path = []): array
    {
        if ($tree['type'] === 'leaf') {
            return [
                'klasifikasi' => $tree['label'],
                'confidence' => $tree['confidence'] ?? 100.0,
                'distribution' => $tree['distribution'] ?? [],
                'path' => $path,
            ];
        }

        $attr = $tree['attribute'];
        $val = $sample[$attr] ?? null;

        if (is_bool($val)) {
            $val = $val ? '1' : '0';
        } elseif ($val === 1 || $val === '1') {
            $val = '1';
        } elseif ($val === 0 || $val === '0') {
            $val = '0';
        } else {
            $val = (string)$val;
        }

        $attrLabel = $tree['attribute_label'] ?? $attr;
        $valDisplay = $val === '1' ? 'Ya' : ($val === '0' ? 'Tidak' : ucfirst($val));

        $path[] = "{$attrLabel} = {$valDisplay}";

        if (isset($tree['branches'][$val])) {
            return $this->predict($sample, $tree['branches'][$val], $path);
        }

        // Fallback: Jika nilai belum pernah ditemui di cabang, gunakan kelas mayoritas node saat ini
        return [
            'klasifikasi' => $tree['majority_class'] ?? 'sedang',
            'confidence' => 60.0,
            'distribution' => $tree['distribution'] ?? [],
            'path' => array_merge($path, ["(Nilai tidak spesifik, fallback ke mayoritas: " . ($tree['majority_class'] ?? 'sedang') . ")"]),
        ];
    }

    /**
     * Ekstraksi Aturan Keputusan (IF-THEN Rules) dari Tree
     */
    public function extractRules(array $tree, array $currentRules = []): array
    {
        if ($tree['type'] === 'leaf') {
            $ruleStr = count($currentRules) > 0 ? implode(' DAN ', $currentRules) : 'Kondisi Umum';
            return [
                [
                    'rule' => "JIKA {$ruleStr} MAKA Klasifikasi = " . strtoupper($tree['label']),
                    'label' => $tree['label'],
                    'samples' => $tree['total_samples'] ?? 0,
                    'confidence' => $tree['confidence'] ?? 100,
                ],
            ];
        }

        $rules = [];
        $attrLabel = $tree['attribute_label'] ?? $tree['attribute'];

        foreach ($tree['branches'] as $val => $subTree) {
            $valDisplay = $val === '1' ? 'Ya' : ($val === '0' ? 'Tidak' : ucfirst($val));
            $ruleItem = "{$attrLabel} = '{$valDisplay}'";
            $subRules = $this->extractRules($subTree, array_merge($currentRules, [$ruleItem]));
            $rules = array_merge($rules, $subRules);
        }

        return $rules;
    }

    /**
     * Evaluasi Performa Model (Akurasi & Confusion Matrix)
     */
    public function evaluate(Collection $dataset, array $tree): array
    {
        $classes = ['ringan', 'sedang', 'berat'];
        $matrix = [];
        foreach ($classes as $actual) {
            foreach ($classes as $pred) {
                $matrix[$actual][$pred] = 0;
            }
        }

        $correct = 0;
        $total = $dataset->count();

        if ($total === 0) {
            return [
                'accuracy' => 0,
                'total' => 0,
                'correct' => 0,
                'incorrect' => 0,
                'matrix' => $matrix,
            ];
        }

        foreach ($dataset as $row) {
            $rowData = is_array($row) ? $row : (method_exists($row, 'toArray') ? $row->toArray() : (array)$row);
            $actual = strtolower($rowData['klasifikasi'] ?? '');
            $prediction = $this->predict($rowData, $tree);
            $predClass = strtolower($prediction['klasifikasi']);

            if (isset($matrix[$actual][$predClass])) {
                $matrix[$actual][$predClass]++;
            }

            if ($actual === $predClass) {
                $correct++;
            }
        }

        $accuracy = round(($correct / $total) * 100, 2);

        return [
            'accuracy' => $accuracy,
            'total' => $total,
            'correct' => $correct,
            'incorrect' => $total - $correct,
            'matrix' => $matrix,
        ];
    }

    /**
     * Hitung rincian komputasi ID3 (Entropi & Gain tiap atribut) untuk transparansi edukatif & akademik
     */
    public function getDetailedCalculation(Collection $data, array $attributes, string $targetAttr = 'klasifikasi'): array
    {
        $total = $data->count();
        if ($total === 0) {
            return [];
        }

        $classes = ['ringan', 'sedang', 'berat'];
        $classCounts = [];
        $classProportions = [];
        $entropyTerms = [];
        $entropyTotal = 0.0;

        foreach ($classes as $cls) {
            $count = $data->where($targetAttr, $cls)->count();
            $classCounts[$cls] = $count;
            $p = $total > 0 ? $count / $total : 0;
            $classProportions[$cls] = round($p, 4);
            $term = $p > 0 ? -($p * log($p, 2)) : 0;
            $entropyTerms[$cls] = round($term, 4);
            $entropyTotal += $term;
        }
        $entropyTotal = round($entropyTotal, 4);

        $attributeCalculations = [];
        foreach ($attributes as $attr) {
            $label = $this->attributeLabels[$attr] ?? ucfirst(str_replace('_', ' ', $attr));

            $subsets = $data->groupBy(function ($item) use ($attr) {
                $val = is_array($item) ? ($item[$attr] ?? '') : ($item->$attr ?? '');
                if (is_bool($val)) return $val ? '1' : '0';
                if ($val === 1 || $val === '1') return '1';
                if ($val === 0 || $val === '0') return '0';
                return (string)$val;
            });

            $branchesCalc = [];
            $sumWeightedEntropy = 0.0;

            foreach ($subsets as $val => $subset) {
                $subTotal = $subset->count();
                $proporsi = $total > 0 ? $subTotal / $total : 0;

                $branchDist = [];
                $branchProp = [];
                $branchTerms = [];
                $branchEntropy = 0.0;

                foreach ($classes as $cls) {
                    $cnt = $subset->where($targetAttr, $cls)->count();
                    $branchDist[$cls] = $cnt;
                    $pBranch = $subTotal > 0 ? $cnt / $subTotal : 0;
                    $branchProp[$cls] = round($pBranch, 4);
                    $tBranch = $pBranch > 0 ? -($pBranch * log($pBranch, 2)) : 0;
                    $branchTerms[$cls] = round($tBranch, 4);
                    $branchEntropy += $tBranch;
                }
                $branchEntropy = round($branchEntropy, 4);
                $weightedBranchEntropy = round($proporsi * $branchEntropy, 4);
                $sumWeightedEntropy += $weightedBranchEntropy;

                $valDisplay = match ((string)$val) {
                    '1' => 'Ya (1)',
                    '0' => 'Tidak (0)',
                    'verbal' => 'Verbal',
                    'fisik' => 'Fisik',
                    'sosial' => 'Sosial',
                    'siber' => 'Siber',
                    'seksual' => 'Seksual',
                    'sekali' => 'Sekali',
                    '2-3_kali' => '2-3 Kali',
                    'sering' => 'Sering',
                    default => ucfirst((string)$val)
                };

                $branchesCalc[] = [
                    'value' => (string)$val,
                    'label' => $valDisplay,
                    'total' => $subTotal,
                    'weight' => round($proporsi, 4),
                    'distribution' => $branchDist,
                    'proportions' => $branchProp,
                    'entropy' => $branchEntropy,
                    'weighted_entropy' => $weightedBranchEntropy,
                ];
            }

            $sumWeightedEntropy = round($sumWeightedEntropy, 4);
            $gain = round($entropyTotal - $sumWeightedEntropy, 4);

            $attributeCalculations[$attr] = [
                'attribute' => $attr,
                'label' => $label,
                'branches' => $branchesCalc,
                'sum_weighted_entropy' => $sumWeightedEntropy,
                'gain' => $gain,
            ];
        }

        uasort($attributeCalculations, function ($a, $b) {
            return $b['gain'] <=> $a['gain'];
        });

        $bestAttribute = !empty($attributeCalculations) ? array_key_first($attributeCalculations) : null;

        return [
            'total_samples' => $total,
            'classes' => $classes,
            'class_counts' => $classCounts,
            'class_proportions' => $classProportions,
            'entropy_terms' => $entropyTerms,
            'entropy_total' => $entropyTotal,
            'attributes' => $attributeCalculations,
            'best_attribute' => $bestAttribute ? $attributeCalculations[$bestAttribute] : null,
        ];
    }
}
