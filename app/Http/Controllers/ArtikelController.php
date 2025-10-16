<?php

namespace App\Http\Controllers;

use App\Models\TbArtikel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ArtikelController extends Controller
{
    public function index()
    {
        $data = TbArtikel::all();
        $title = 'Hapus Artikel';
        $text = "Apakah anda yakin untuk hapus?";
        confirmDelete($title, $text);
        return view('admin.artikel.index', compact('data'));
    }

    public function indexUser()
    {
        $data = TbArtikel::all();
        return view('article_user', compact('data'));
    }

    public function articleDetail($id)
    {
        $data = TbArtikel::findOrFail($id);
        return view('article_detail', compact('data'));
    }

    public function create()
    {
        return view('admin.artikel.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['judul', 'konten', 'kategori', 'author']);

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $image->storeAs('public/foto-artikel', $image->hashName());
            $data['gambar'] = $image->hashName();
        }

        $data['created_at'] = now();

        TbArtikel::create($data);

        Alert::success('Success', 'Artikel berhasil disimpan');

        return redirect()->route('admin.artikel.index');
    }

    public function edit(TbArtikel $artikel)
    {
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, TbArtikel $artikel)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $artikel->judul = $request->judul;
        $artikel->konten = $request->konten;
        $artikel->kategori = $request->kategori;
        $artikel->author = $request->author;

        if ($request->hasFile('gambar')) {
            if ($artikel->gambar) {
                Storage::delete('public/foto-artikel/' . $artikel->gambar);
            }
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/foto-artikel', $gambar->hashName());
            $artikel->gambar = $gambar->hashName();
        }

        $artikel->save();

        Alert::success('Success', 'Artikel berhasil diupdate');

        return redirect()->route('admin.artikel.index');
    }

    public function destroy(TbArtikel $artikel)
    {
        if ($artikel->gambar) {
            Storage::delete('public/foto-artikel/' . $artikel->gambar);
        }

        $artikel->delete();

        Alert::success('Success', 'Artikel berhasil dihapus');

        return redirect()->route('admin.artikel.index');
    }

    public function export()
    {
        $artikel = TbArtikel::all();
        $pdf = Pdf::loadview('admin.artikel.export_pdf', ['data' => $artikel]);
        return $pdf->download('laporan-artikel.pdf');
    }
}
