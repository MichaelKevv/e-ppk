<?php

namespace App\Http\Controllers;

use App\Models\SurveyData;
use Illuminate\Http\Request;

class SurveyDataController extends Controller
{
    public function index()
    {
        $surveys = SurveyData::latest()->paginate(10);
        return view('admin.survey.index', compact('surveys'));
    }

    public function create()
    {
        return view('admin.survey.create');
    }

    public function store(Request $request)
    {
        // Ambil semua data request
        $inputs = $request->all();

        // Hitung rata-rata untuk setiap kategori
        $categories = [
            'perceived_usefulness' => 'perceived-usefulness',
            'perceived_ease_of_use' => 'perceived-ease-of-use',
            'behavioral_intention_to_use' => 'behavioral-intention-to-use',
        ];

        $averages = [];

        foreach ($categories as $field => $prefix) {
            $filtered = collect($inputs)
                ->filter(fn($value, $key) => str_starts_with($key, $prefix))
                ->map(fn($value) => (int) $value);

            $averages[$field] = $filtered->count() > 0 ? round($filtered->avg(), 2) : null;
        }

        // Gabungkan data lain seperti nama responden & email
        $data = [
            'respondent_name' => $request->input('respondent_name'),
            'id_pengaduan' => $request->input('id_pengaduan'),
            'email' => $request->input('email'),
            'perceived_usefulness' => $averages['perceived_usefulness'],
            'perceived_ease_of_use' => $averages['perceived_ease_of_use'],
            'behavioral_intention_to_use' => $averages['behavioral_intention_to_use'],
        ];

        // Validasi data (optional bisa disesuaikan)
        $request->validate([
            'respondent_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        // Simpan ke tabel survey
        SurveyData::create($data);

        return redirect()->route('admin.survey.index')
            ->with('success', 'Data survey berhasil disimpan.');
    }

    public function show($id)
    {
        $survey = SurveyData::findOrFail($id);
        return view('admin.survey.show', compact('survey'));
    }

    public function destroy($id)
    {
        SurveyData::destroy($id);
        return redirect()->route('admin.survey.index')->with('success', 'Data survey berhasil dihapus.');
    }

    // Analisis sederhana TAM
    public function analysis()
    {
        $totalSurvey = SurveyData::count();
        $avgPU = SurveyData::avg('perceived_usefulness');
        $avgPEOU = SurveyData::avg('perceived_ease_of_use');
        $avgBI = SurveyData::avg('behavioral_intention_to_use');

        return view('admin.survey.analysis', compact('avgPU', 'avgPEOU', 'avgBI', 'totalSurvey'));
    }
}
