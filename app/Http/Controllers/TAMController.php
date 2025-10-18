<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class TAMController extends Controller
{
    public function index()
    {
        return view('admin.metode.tam');
    }

    public function hitung(Request $request)
    {
        $feedback = Feedback::all();

        // Rumus dasar TAM: rata-rata indikator PU, PEOU, ATT, BI
        $pu = $feedback->avg('perceived_usefulness');
        $peou = $feedback->avg('perceived_ease_of_use');
        $att = $feedback->avg('attitude_toward_using');
        $bi = $feedback->avg('behavioral_intention_to_use');

        $hasil = [
            'PU' => round($pu, 2),
            'PEOU' => round($peou, 2),
            'ATT' => round($att, 2),
            'BI' => round($bi, 2),
        ];

        return view('admin.metode.tam', compact('hasil'));
    }
}
