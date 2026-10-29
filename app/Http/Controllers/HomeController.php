<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Dinso;
use App\Models\Gurubk;
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

    public function articleDetail($id)
    {
        $article = Artikel::findOrFail($id);
        $recentArticles = Artikel::where('id_artikel', '!=', $id)->latest()->take(3)->get();
        return view('front.article_detail', compact('article', 'recentArticles'));
    }

    public function kontakPetugas()
    {
        $petugas = Dinso::all();
        $guruBk = Gurubk::with('sekolah')->get();
        return view('front.kontak_user', compact('petugas', 'guruBk'));
    }
}
