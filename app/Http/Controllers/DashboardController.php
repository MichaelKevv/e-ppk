<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Pengaduan;
use App\Models\TbPetuga;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getPengaduanData()
    {
        if (Auth::user()->role == 'siswa') {
            $pengaduanData = Pengaduan::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->where('id_siswa', session('userdata')->id_siswa)
                ->groupBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();
        } else {
            $pengaduanData = Pengaduan::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
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
        $siswaData = Siswa::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
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
        $feedbackData = Feedback::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
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
    //     if (Auth::user()->role == 'siswa') {
    //         $id_siswa = session('userdata')->id_siswa;
    //         $data['totalPengaduan'] = Pengaduan::where('id_siswa', $id_siswa)->count();
    //         $data['pengaduanFeedback'] = Pengaduan::where('id_siswa', $id_siswa)
    //         ->where(function($query) {
    //             $query->where('status', 'diproses')
    //                     ->orWhere('status', 'ditutup');
    //         })
    // ->count();
    //     } else {
    //         $data['totalSiswa'] = Siswa::count();
    //         $data['totalPengaduan'] = Pengaduan::count();
    //         $data['totalFeedback'] = Feedback::count();
    //         $data['pengaduanBelumDibaca'] = Pengaduan::where('status', 'dibuka')
    //             ->orWhere('status', 'diproses')
    //             ->count();
    //     }
        return view('admin.dashboard');
    }
    public function indexUser()
    {
        return view('front.home');
    }
    // public function kontakPetugas()
    // {
    //     $data = TbPetuga::all();
    //     return view('kontak_user', compact('data'));
    // }
}
