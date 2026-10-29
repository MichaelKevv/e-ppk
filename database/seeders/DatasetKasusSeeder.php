<?php

namespace Database\Seeders;

use App\Models\DatasetKasus;
use Illuminate\Database\Seeder;

class DatasetKasusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases = [
            // Kasus Verbal (Ringan, Sedang, Berat)
            ['verbal', 'sekali', 0, 0, 0, 0, 'ringan'],
            ['verbal', 'sekali', 0, 0, 1, 0, 'ringan'],
            ['verbal', '2-3_kali', 0, 0, 0, 0, 'ringan'],
            ['verbal', '2-3_kali', 0, 0, 1, 0, 'sedang'],
            ['verbal', '2-3_kali', 1, 0, 0, 0, 'sedang'],
            ['verbal', 'sering', 0, 0, 0, 0, 'sedang'],
            ['verbal', 'sering', 0, 0, 1, 0, 'sedang'],
            ['verbal', 'sering', 1, 0, 0, 0, 'berat'],
            ['verbal', 'sering', 1, 0, 1, 0, 'berat'],
            ['verbal', '2-3_kali', 1, 0, 1, 0, 'sedang'],
            ['verbal', 'sekali', 1, 0, 0, 0, 'sedang'],
            ['verbal', 'sering', 0, 0, 0, 0, 'sedang'],

            // Kasus Fisik (Dominan Sedang & Berat)
            ['fisik', 'sekali', 0, 0, 0, 0, 'sedang'],
            ['fisik', 'sekali', 0, 1, 0, 0, 'sedang'],
            ['fisik', 'sekali', 1, 1, 0, 0, 'berat'],
            ['fisik', 'sekali', 0, 1, 1, 0, 'berat'],
            ['fisik', '2-3_kali', 0, 0, 0, 0, 'sedang'],
            ['fisik', '2-3_kali', 0, 1, 0, 0, 'berat'],
            ['fisik', '2-3_kali', 1, 1, 0, 0, 'berat'],
            ['fisik', '2-3_kali', 0, 1, 1, 0, 'berat'],
            ['fisik', '2-3_kali', 1, 1, 1, 0, 'berat'],
            ['fisik', 'sering', 0, 0, 0, 0, 'sedang'],
            ['fisik', 'sering', 0, 1, 0, 0, 'berat'],
            ['fisik', 'sering', 1, 1, 0, 0, 'berat'],
            ['fisik', 'sering', 1, 1, 1, 0, 'berat'],
            ['fisik', 'sering', 1, 0, 1, 0, 'berat'],

            // Kasus Sosial / Relasional (Pengucilan, fitnah kelompok)
            ['sosial', 'sekali', 0, 0, 0, 0, 'ringan'],
            ['sosial', 'sekali', 0, 0, 1, 0, 'ringan'],
            ['sosial', '2-3_kali', 0, 0, 0, 0, 'ringan'],
            ['sosial', '2-3_kali', 0, 0, 1, 0, 'sedang'],
            ['sosial', '2-3_kali', 1, 0, 0, 0, 'sedang'],
            ['sosial', 'sering', 0, 0, 0, 0, 'sedang'],
            ['sosial', 'sering', 0, 0, 1, 0, 'sedang'],
            ['sosial', 'sering', 1, 0, 1, 0, 'berat'],
            ['sosial', 'sering', 1, 0, 0, 0, 'berat'],
            ['sosial', '2-3_kali', 1, 0, 1, 0, 'sedang'],
            ['sosial', 'sekali', 1, 0, 0, 0, 'sedang'],

            // Kasus Siber / Cyberbullying
            ['siber', 'sekali', 0, 0, 0, 1, 'ringan'],
            ['siber', 'sekali', 0, 0, 1, 1, 'sedang'],
            ['siber', 'sekali', 1, 0, 0, 1, 'sedang'],
            ['siber', '2-3_kali', 0, 0, 0, 1, 'sedang'],
            ['siber', '2-3_kali', 0, 0, 1, 1, 'sedang'],
            ['siber', '2-3_kali', 1, 0, 0, 1, 'berat'],
            ['siber', 'sering', 0, 0, 0, 1, 'sedang'],
            ['siber', 'sering', 0, 0, 1, 1, 'berat'],
            ['siber', 'sering', 1, 0, 0, 1, 'berat'],
            ['siber', 'sering', 1, 0, 1, 1, 'berat'],
            ['siber', '2-3_kali', 1, 0, 1, 1, 'berat'],

            // Kasus Seksual (Pelecehan verbal/fisik/digital - mayoritas Berat / Sedang)
            ['seksual', 'sekali', 0, 0, 0, 0, 'sedang'],
            ['seksual', 'sekali', 1, 0, 0, 0, 'berat'],
            ['seksual', 'sekali', 0, 0, 1, 0, 'berat'],
            ['seksual', 'sekali', 0, 0, 0, 1, 'sedang'],
            ['seksual', 'sekali', 1, 0, 0, 1, 'berat'],
            ['seksual', '2-3_kali', 0, 0, 0, 0, 'berat'],
            ['seksual', '2-3_kali', 1, 0, 0, 0, 'berat'],
            ['seksual', '2-3_kali', 1, 1, 0, 0, 'berat'],
            ['seksual', '2-3_kali', 1, 0, 1, 1, 'berat'],
            ['seksual', 'sering', 0, 0, 0, 0, 'berat'],
            ['seksual', 'sering', 1, 0, 0, 0, 'berat'],
            ['seksual', 'sering', 1, 1, 1, 1, 'berat'],
        ];

        // Hapus data history lama tanpa menghapus pengaduan asli siswa
        \App\Models\Pengaduan::where('sumber', 'history')->delete();

        foreach ($cases as $index => $c) {
            \App\Models\Pengaduan::create([
                'id_sekolah' => 1,
                'kode_kasus' => sprintf('KS-%03d', $index + 1),
                'nama_pelaku' => 'Dataset Historis',
                'nama_pelapor' => 'Arsip Kasus Sekolah',
                'bentuk_perundungan' => $c[0],
                'frekuensi_kejadian' => $c[1],
                'lokasi' => 'Lingkungan Sekolah',
                'trauma_mental' => (bool)$c[2],
                'luka_fisik' => (bool)$c[3],
                'pelaku_lebih_dari_satu' => (bool)$c[4],
                'konten_digital' => (bool)$c[5],
                'klasifikasi' => $c[6],
                'deskripsi' => 'Data historis kasus perundungan untuk pelatihan model Decision Tree (ID3).',
                'status' => 'history',
                'sumber' => 'history',
            ]);
        }
    }
}
