<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // ambil 3 artikel terbaru, bisa diubah sesuai kebutuhan
        $articles = Artikel::latest()->take(3)->get();

        // atau jika mau tampilkan semua: Artikel::latest()->paginate(6);

        return view('front.home', compact('articles'));
    }

    public function allArticles()
    {
        $articles = Artikel::latest()->paginate(6);
        return view('front.article_list', compact('articles'));
    }
}
