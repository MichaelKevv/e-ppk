<?php

namespace App\Http\Controllers;

use App\Models\TbFeedback;
use App\Models\TbPengaduan;
use App\Models\TbPetuga;
use App\Models\TbSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getPengaduanData()
    {
        if (Auth::user()->role == 'siswa') {
            $pengaduanData = TbPengaduan::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->where('id_siswa', session('userdata')->id_siswa)
                ->groupBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();
        } else {
            $pengaduanData = TbPengaduan::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();
        }

        $formattedData = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedData[] = $pengaduanData[$i] ?? 0;
        }

        return response()->json($formattedData);
    }

    public function getSiswaData()
    {
        $siswaData = TbSiswa::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $formattedData = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedData[] = $siswaData[$i] ?? 0;
        }

        return response()->json($formattedData);
    }

    public function getFeedbackData()
    {
        $feedbackData = TbFeedback::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $formattedData = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedData[] = $feedbackData[$i] ?? 0;
        }

        return response()->json($formattedData);
    }

    public function index()
    {
        if (Auth::user()->role == 'siswa') {
            $id_siswa = session('userdata')->id_siswa;
            $data['totalPengaduan'] = TbPengaduan::where('id_siswa', $id_siswa)->count();
            $data['pengaduanFeedback'] = TbPengaduan::where('status', 'diproses')
                ->orWhere('status', 'ditutup')
                ->where('id_siswa', $id_siswa)
                ->count();
        } else {
            $data['totalSiswa'] = TbSiswa::count();
            $data['totalPengaduan'] = TbPengaduan::count();
            $data['totalFeedback'] = TbFeedback::count();
            $data['pengaduanBelumDibaca'] = TbPengaduan::where('status', 'dibuka')
                ->orWhere('status', 'diproses')
                ->count();
        }
        return view('dashboard', compact('data'));
    }
    public function indexUser()
    {
        return view('dashboard_user');
    }
    public function kontakPetugas()
    {
        $data = TbPetuga::all();
        return view('kontak_user', compact('data'));
    }
}
