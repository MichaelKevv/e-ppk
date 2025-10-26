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
        $request->validate([
            'respondent_name' => 'required|string|max:255',
            'perceived_usefulness' => 'required|integer|min:1|max:5',
            'perceived_ease_of_use' => 'required|integer|min:1|max:5',
            'attitude_toward_using' => 'required|integer|min:1|max:5',
            'behavioral_intention_to_use' => 'required|integer|min:1|max:5',
            'actual_system_use' => 'required|integer|min:1|max:5',
        ]);

        SurveyData::create($request->all());

        return redirect()->route('admin.survey.index')->with('success', 'Data survey berhasil disimpan.');
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
        $avgATU = SurveyData::avg('attitude_toward_using');
        $avgBI = SurveyData::avg('behavioral_intention_to_use');
        $avgASU = SurveyData::avg('actual_system_use');

        return view('admin.survey.analysis', compact('avgPU', 'avgPEOU', 'avgATU', 'avgBI', 'avgASU','totalSurvey'));
    }
}
