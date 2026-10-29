<?php

namespace App\Http\Controllers;

use App\Models\SurveyData;
use Illuminate\Http\Request;

class SurveyDataController extends Controller
{
    public function index(Request $request)
    {
        $query = SurveyData::with('pengaduan')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('respondent_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $surveys = $query->paginate(10)->withQueryString();

        // Metrik Ringkasan TAM untuk Header Card
        $totalSurvey = SurveyData::count();
        $avgPU = $totalSurvey > 0 ? round((float)SurveyData::avg('perceived_usefulness'), 2) : 0.0;
        $avgPEOU = $totalSurvey > 0 ? round((float)SurveyData::avg('perceived_ease_of_use'), 2) : 0.0;
        $avgBI = $totalSurvey > 0 ? round((float)SurveyData::avg('behavioral_intention_to_use'), 2) : 0.0;
        $overallScore = $totalSurvey > 0 ? round(($avgPU + $avgPEOU + $avgBI) / 3, 2) : 0.0;
        $acceptanceRate = $overallScore > 0 ? round(($overallScore / 5) * 100, 1) : 0.0;

        return view('admin.survey.index', compact(
            'surveys',
            'totalSurvey',
            'avgPU',
            'avgPEOU',
            'avgBI',
            'overallScore',
            'acceptanceRate'
        ));
    }

    public function create()
    {
        $pengaduanList = \App\Models\Pengaduan::latest()->take(20)->get(['id_pengaduan', 'kode_kasus', 'nama_pelapor']);
        return view('admin.survey.create', compact('pengaduanList'));
    }

    public function store(Request $request)
    {
        // Ambil semua data request
        $inputs = $request->all();

        // Hitung rata-rata untuk setiap kategori jika ada sub-item
        $categories = [
            'perceived_usefulness' => 'perceived-usefulness',
            'perceived_ease_of_use' => 'perceived-ease-of-use',
            'behavioral_intention_to_use' => 'behavioral-intention-to-use',
        ];

        $averages = [];

        foreach ($categories as $field => $prefix) {
            $filtered = collect($inputs)
                ->filter(fn($value, $key) => str_starts_with($key, $prefix))
                ->map(fn($value) => (float) $value);

            if ($filtered->count() > 0) {
                $averages[$field] = round($filtered->avg(), 2);
            } else {
                // Jika input langsung angka (direct field)
                $averages[$field] = $request->filled($field) ? (float)$request->input($field) : 4.0;
            }
        }

        // Gabungkan data
        $data = [
            'respondent_name' => $request->input('respondent_name'),
            'id_pengaduan' => $request->input('id_pengaduan'),
            'email' => $request->input('email'),
            'perceived_usefulness' => $averages['perceived_usefulness'],
            'perceived_ease_of_use' => $averages['perceived_ease_of_use'],
            'behavioral_intention_to_use' => $averages['behavioral_intention_to_use'],
        ];

        $request->validate([
            'respondent_name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'perceived_usefulness' => 'nullable|numeric|min:1|max:5',
            'perceived_ease_of_use' => 'nullable|numeric|min:1|max:5',
            'behavioral_intention_to_use' => 'nullable|numeric|min:1|max:5',
        ]);

        SurveyData::create($data);

        return redirect()->route('admin.survey.index')
            ->with('success', 'Data survey TAM berhasil disimpan.');
    }

    public function show($id)
    {
        $survey = SurveyData::with('pengaduan')->findOrFail($id);
        $meanScore = round(($survey->perceived_usefulness + $survey->perceived_ease_of_use + $survey->behavioral_intention_to_use) / 3, 2);
        $acceptancePct = round(($meanScore / 5) * 100, 1);

        return view('admin.survey.show', compact('survey', 'meanScore', 'acceptancePct'));
    }

    public function destroy($id)
    {
        SurveyData::destroy($id);
        return redirect()->route('admin.survey.index')->with('success', 'Data survey berhasil dihapus.');
    }

    // Analisis diarahkan ke Kalkulasi Model TAM terpadu
    public function analysis()
    {
        return redirect()->route('admin.tam.index');
    }
}
