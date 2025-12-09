<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gurubk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruBKController extends Controller
{
    public function index()
    {
        $guruBks = Gurubk::orderBy('nama')->paginate(10);
        return view('admin.guru_bk.index', compact('guruBks'));
    }
    public function create()
    {
        return view('admin.guru_bk.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:20|unique:guru_bk,nip',
            'nama' => 'required|string|max:100',
            'gender' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('guru_bk/foto', 'public');
            $validated['foto'] = $fotoPath;
        }

        Gurubk::create($validated);

        return redirect()->route('admin.guru-bk.index')
            ->with('success', 'Data Guru BK berhasil ditambahkan.');
    }
    public function show(Gurubk $guruBk)
    {
        return view('admin.guru_bk.show', compact('guruBk'));
    }
    public function edit(Gurubk $guruBk)
    {
        return view('admin.guru_bk.edit', compact('guruBk'));
    }
    public function update(Request $request, Gurubk $guruBk)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'gender' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($guruBk->foto) {
                Storage::disk('public')->delete($guruBk->foto);
            }

            $fotoPath = $request->file('foto')->store('guru_bk/foto', 'public');
            $validated['foto'] = $fotoPath;
        }

        $guruBk->update($validated);

        return redirect()->route('admin.guru-bk.index')
            ->with('success', 'Data Guru BK berhasil diperbarui.');
    }
    public function destroy(Gurubk $guruBk)
    {
        // Hapus foto jika ada
        if ($guruBk->foto) {
            Storage::disk('public')->delete($guruBk->foto);
        }

        $guruBk->delete();

        return redirect()->route('admin.guru-bk.index')
            ->with('success', 'Data Guru BK berhasil dihapus.');
    }
}
