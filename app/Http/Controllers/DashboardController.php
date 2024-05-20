<?php

namespace App\Http\Controllers;

use App\Models\TbPetuga;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
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
