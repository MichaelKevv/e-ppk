<?php

namespace App\Http\Controllers;

use App\Models\TbArtikel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ArtikelController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TbArtikel::all();
        $title = 'Hapus Siswa';
        $text = "Apakah anda yakin untuk hapus?";
        confirmDelete($title, $text);
        return view('artikel/index', compact('data'));
    }

    public function indexUser()
    {
        $data = TbArtikel::all();
        return view('artikel_user', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('artikel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->route('artikel.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TbArtikel $artikel)
    {
        return view('artikel/edit', compact('artikel', 'artikel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->route('artikel.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TbArtikel $artikel)
    {
        if ($artikel->gambar) {
            Storage::delete('public/foto-artikel/' . $artikel->gambar);
        }

        // Hapus artikel
        $artikel->delete();

        Alert::success('Success', 'Artikel berhasil dihapus');

        return redirect()->route('artikel.index');
    }
}
