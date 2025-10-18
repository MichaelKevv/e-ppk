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

    public function proses(Request $request)
    {
        // Contoh logika sederhana Decision Tree
        $data = Pengaduan::all();
        $hasil = [];

        foreach ($data as $d) {
            if ($d->tingkat_kekerasan == 'tinggi' && $d->pelaku == 'guru') {
                $hasil[] = ['id' => $d->id_pengaduan, 'klasifikasi' => 'Serius'];
            } else {
                $hasil[] = ['id' => $d->id_pengaduan, 'klasifikasi' => 'Ringan'];
            }
        }

        return view('admin.metode.decision-tree', compact('hasil', 'data'));
    }
}

