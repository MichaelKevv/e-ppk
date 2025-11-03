<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use RealRashid\SweetAlert\Facades\Alert;

class PengaduanController extends Controller
{
    public function index()
    {
        $data = Pengaduan::orderBy('created_at', 'desc')->get();
        return view('admin.pengaduan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pengaduan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelaku' => 'required|string|max:255',
            'nama_pelapor' => 'nullable|string|max:255',
            'bentuk_perundungan' => 'required|in:verbal,fisik,sosial,siber,seksual',
            'frekuensi_kejadian' => 'required|in:sekali,2-3_kali,sering',
            'lokasi' => 'nullable|string|max:255',
            'trauma_mental' => 'nullable|boolean',
            'luka_fisik' => 'nullable|boolean',
            'pelaku_lebih_dari_satu' => 'nullable|boolean',
            'konten_digital' => 'nullable|boolean',
            'jenis_kata' => 'nullable|string|max:255',
            'klasifikasi' => 'required|in:ringan,sedang,berat',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = "Pengaduan gagal dibuat.<br>";
            foreach ($errors as $error) {
                $errorMessage .= "$error<br>";
            }
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        DB::beginTransaction();

        try {
            $data = $request->only([
                'nama_pelaku',
                'nama_pelapor',
                'bentuk_perundungan',
                'frekuensi_kejadian',
                'lokasi',
                'trauma_mental',
                'luka_fisik',
                'pelaku_lebih_dari_satu',
                'konten_digital',
                'jenis_kata',
                'klasifikasi',
                'deskripsi',
            ]);

            // Upload foto jika ada
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = uniqid('pengaduan_') . '.webp';
                $manager = new ImageManager(new Driver());

                $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
                Storage::disk('public')->put('pengaduan/foto/lg/' . $filename, (string)$lg);

                $data['foto'] = $filename;
            }

            Pengaduan::create($data);
            DB::commit();

            return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.pengaduan.detail', compact('pengaduan'));
    }

    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.pengaduan.edit', compact('pengaduan'));
    }

    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_pelaku' => 'required|string|max:255',
            'nama_pelapor' => 'nullable|string|max:255',
            'bentuk_perundungan' => 'required|in:verbal,fisik,sosial,siber,seksual',
            'frekuensi_kejadian' => 'required|in:sekali,2-3_kali,sering',
            'lokasi' => 'nullable|string|max:255',
            'trauma_mental' => 'nullable|boolean',
            'luka_fisik' => 'nullable|boolean',
            'pelaku_lebih_dari_satu' => 'nullable|boolean',
            'konten_digital' => 'nullable|boolean',
            'jenis_kata' => 'nullable|string|max:255',
            'klasifikasi' => 'required|in:ringan,sedang,berat',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = "Pengaduan gagal diperbarui.<br>";
            foreach ($errors as $error) {
                $errorMessage .= "$error<br>";
            }
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        DB::beginTransaction();

        try {
            $pengaduan->update($request->except('foto'));

            if ($request->hasFile('foto')) {
                if ($pengaduan->foto) {
                    Storage::disk('public')->delete('pengaduan/foto/lg/' . $pengaduan->foto);
                }

                $file = $request->file('foto');
                $filename = uniqid('pengaduan_') . '.webp';
                $manager = new ImageManager(new Driver());
                $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
                Storage::disk('public')->put('pengaduan/foto/lg/' . $filename, (string)$lg);

                $pengaduan->update(['foto' => $filename]);
            }

            DB::commit();
            return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($pengaduan->foto) {
                Storage::disk('public')->delete('pengaduan/foto/lg/' . $pengaduan->foto);
            }
            $pengaduan->delete();
            DB::commit();

            return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function export()
    {
        $pengaduan = Pengaduan::all();
        $pdf = Pdf::loadview('admin.pengaduan.export_pdf', ['data' => $pengaduan]);
        return $pdf->download('laporan-pengaduan.pdf');
    }

    public function export_single($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pdf = Pdf::loadview('admin.pengaduan.export_single', compact('pengaduan'));
        return $pdf->download('laporan-pengaduan-' . $pengaduan->nama_pelapor . '.pdf');
    }
}
