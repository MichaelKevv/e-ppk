<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Dinso;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Artikel::latest()->take(3)->get();
        return view('front.home', compact('articles'));
    }

    public function allArticles()
    {
        $articles = Artikel::latest()->paginate(6);
        return view('front.article_list', compact('articles'));
    }
    public function kontakPetugas()
    {
        $petugas = Dinso::all();
        return view('front.kontak_user', compact('petugas'));
    }
}
