<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Pengaduan;
use App\Models\TbPetuga;
use App\Models\Siswa;
use App\Models\Artikel;
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

    public function getDashboardStats()
    {
        $stats = [];
        
        if (Auth::user()->role == 'siswa') {
            $id_siswa = session('userdata')->id_siswa;
            
            $stats['total_pengaduan'] = Pengaduan::where('id_siswa', $id_siswa)->count();
            $stats['pengaduan_diproses'] = Pengaduan::where('id_siswa', $id_siswa)
                ->where('status', 'diproses')
                ->count();
            $stats['pengaduan_selesai'] = Pengaduan::where('id_siswa', $id_siswa)
                ->where('status', 'ditutup')
                ->count();
        } else {
            $stats['total_siswa'] = Siswa::count();
            $stats['total_pengaduan'] = Pengaduan::count();
            $stats['total_feedback'] = Feedback::count();
            $stats['total_artikel'] = Artikel::count() ?? 0; // Default ke 0 jika model tidak ada
        }
        
        return response()->json($stats);
    }

    public function index()
    {
        if (Auth::user()->role == 'siswa') {
            $id_siswa = session('userdata')->id_siswa;
            
            $data['totalPengaduan'] = Pengaduan::where('id_siswa', $id_siswa)->count();
            $data['pengaduanDiproses'] = Pengaduan::where('id_siswa', $id_siswa)
                ->where('status', 'diproses')
                ->count();
            $data['pengaduanSelesai'] = Pengaduan::where('id_siswa', $id_siswa)
                ->where('status', 'ditutup')
                ->count();
            $data['feedbackDiterima'] = Feedback::whereHas('pengaduan', function($query) use ($id_siswa) {
                $query->where('id_siswa', $id_siswa);
            })->count();
                
        } else {
            // Data untuk admin, petugas, dan kepala sekolah
            $data['totalSiswa'] = Siswa::count();
            $data['totalPengaduan'] = Pengaduan::count();
            $data['totalFeedback'] = Feedback::count();
            $data['totalArtikel'] = class_exists(Artikel::class) ? Artikel::count() : 0;
             
            // Statistik pengaduan berdasarkan klasifikasi
            $data['pengaduanRingan'] = Pengaduan::where('klasifikasi', 'ringan')->count();
            $data['pengaduanSedang'] = Pengaduan::where('klasifikasi', 'sedang')->count();
            $data['pengaduanBerat'] = Pengaduan::where('klasifikasi', 'berat')->count();
            
            // Pengaduan bulan ini
            $data['pengaduanBulanIni'] = Pengaduan::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();
                
            // Feedback bulan ini
            $data['feedbackBulanIni'] = Feedback::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();
        }

        return view('admin.dashboard', compact('data'));
    }

    public function indexUser()
    {
        return view('front.home');
    }
}