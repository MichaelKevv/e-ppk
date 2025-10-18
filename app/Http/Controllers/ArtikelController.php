<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use RealRashid\SweetAlert\Facades\Alert;

class ArtikelController extends Controller
{
    public function index()
    {
        $data = Artikel::all();
        return view('admin.artikel.index', compact('data'));
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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['judul', 'konten', 'kategori']);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $ext  = 'webp';
            $filename = uniqid() . '.' . $ext;
            $manager = new ImageManager(new Driver());
            $sm = $manager->read($file)->scale(300, 300)->toWebp(80);
            Storage::disk('public')->put('artikel/gambar/sm/' . $filename, (string) $sm);
            $md = $manager->read($file)->scale(600, 600)->toWebp(80);
            Storage::disk('public')->put('artikel/gambar/md/' . $filename, (string) $md);
            $lg = $manager->read($file)->scale(1000, 1000)->toWebp(80);
            Storage::disk('public')->put('artikel/gambar/lg/' . $filename, (string) $lg);

            $data['gambar'] = $filename;
        }

        // $data['author'] = Auth::user()->admins->first()->id_admin;
        $data['author'] = optional(Auth::user()->admins->first())->id_admin;

        Artikel::create($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan');
    }

    public function edit(Artikel $artikel)
    {
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string|max:255',
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
                $filename = basename($artikel->gambar);
                Storage::disk('public')->delete('artikel/gambar/sm/' . $filename);
                Storage::disk('public')->delete('artikel/gambar/md/' . $filename);
                Storage::disk('public')->delete('artikel/gambar/lg/' . $filename);
            }
            $file = $request->file('gambar');
            $ext  = 'webp';
            $filename = uniqid() . '.' . $ext;
            $manager = new ImageManager(new Driver());
            $sm = $manager->read($file)->scale(300, 300)->toWebp(80);
            Storage::disk('public')->put('artikel/gambar/sm/' . $filename, (string) $sm);
            $md = $manager->read($file)->scale(600, 600)->toWebp(80);
            Storage::disk('public')->put('artikel/gambar/md/' . $filename, (string) $md);
            $lg = $manager->read($file)->scale(1000, 1000)->toWebp(80);
            Storage::disk('public')->put('artikel/gambar/lg/' . $filename, (string) $lg);
            $artikel->gambar = $filename;
        }

        $artikel->save();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diupdate');
    }

    public function destroy(Artikel $artikel)
    {
        if ($artikel->gambar) {
            Storage::disk('public')->delete('artikel/gambar/sm/' . $artikel->gambar);
            Storage::disk('public')->delete('artikel/gambar/md/' . $artikel->gambar);
            Storage::disk('public')->delete('artikel/gambar/lg/' . $artikel->gambar);
        }

        $artikel->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus');
    }
}
