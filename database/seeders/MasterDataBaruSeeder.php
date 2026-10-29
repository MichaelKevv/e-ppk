<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\GuruBK;
use App\Models\Dinsos;
use App\Models\Siswa;
use App\Models\Pengaduan;
use App\Models\Feedback;
use App\Models\SurveyData;
use App\Services\DecisionTreeService;

class MasterDataBaruSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Bersihkan tabel-tabel sesuai instruksi
        DB::table('survey_data')->truncate();
        DB::table('feedback')->truncate();
        DB::table('riwayat_penanganan_kasus')->truncate();
        DB::table('pengaduan')->truncate();
        DB::table('siswa')->truncate();
        DB::table('gurubk')->truncate();
        DB::table('dinsos')->truncate();
        DB::table('sekolah')->truncate();

        // Bersihkan users non-admin (hanya sisakan user role admin dengan id_pengguna = 1)
        DB::table('users')->where('id_pengguna', '!=', 1)->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Buat 5 Data Sekolah Baru sesuai data resmi yang diberikan user
        $sekolahData = [
            1 => [
                'id' => 1,
                'nama_sekolah' => 'SMP Negeri 1 Probolinggo',
                'npsn' => '20536265',
                'jenjang' => 'SMP',
                'status_sekolah' => 'Negeri',
                'akreditasi' => 'A',
                'alamat' => 'Jl. Imam Bonjol No. 49, Sukabumi, Mayangan, Kota Probolinggo, Jawa Timur 67219',
                'kelurahan' => 'Sukabumi',
                'kecamatan' => 'Mayangan',
                'kota' => 'Kota Probolinggo',
                'provinsi' => 'Jawa Timur',
                'kode_pos' => '67219',
                'no_telp' => '(0335) 421234',
                'email' => 'smpn1_probolinggo@yahoo.co.id',
                'website' => 'https://smpn1probolinggo.sch.id',
                'kepala_sekolah' => 'Zakial Irfan, S.Pd., M.Pd.',
                'nip_kepala_sekolah' => '196805121994121002',
                'deskripsi' => 'SMP Negeri 1 Probolinggo. Tanggal Berdiri: 1 Februari 1940. Akreditasi: A.',
                'dataset_target' => 59,
            ],
            2 => [
                'id' => 2,
                'nama_sekolah' => 'SMP Negeri 2 Probolinggo',
                'npsn' => '20536273',
                'jenjang' => 'SMP',
                'status_sekolah' => 'Negeri',
                'akreditasi' => 'A',
                'alamat' => 'Jl. Dr. Moch. Saleh No. 7, Tisnonegaran, Kec. Kanigaran, Kota Probolinggo, Jawa Timur 67211',
                'kelurahan' => 'Tisnonegaran',
                'kecamatan' => 'Kanigaran',
                'kota' => 'Kota Probolinggo',
                'provinsi' => 'Jawa Timur',
                'kode_pos' => '67211',
                'no_telp' => '(0335) 421890',
                'email' => 'info@smpn2probolinggo.sch.id',
                'website' => 'https://smpn2probolinggo.sch.id',
                'kepala_sekolah' => 'Sandi Purwanto, S.E., M.Pd.',
                'nip_kepala_sekolah' => '197103151997021003',
                'deskripsi' => 'SMP Negeri 2 Probolinggo. Terakreditasi A, beralamat di Jl. Dr. Moch. Saleh No. 7 Tisnonegaran.',
                'dataset_target' => 45,
            ],
            3 => [
                'id' => 3,
                'nama_sekolah' => 'SMP Negeri 3 Probolinggo',
                'npsn' => '20536272',
                'jenjang' => 'SMP',
                'status_sekolah' => 'Negeri',
                'akreditasi' => 'A',
                'alamat' => 'Jl. Hayam Wuruk No. 155, Kelurahan Jati, Kecamatan Mayangan, Kota Probolinggo, Jawa Timur',
                'kelurahan' => 'Jati',
                'kecamatan' => 'Mayangan',
                'kota' => 'Kota Probolinggo',
                'provinsi' => 'Jawa Timur',
                'kode_pos' => '67217',
                'no_telp' => '(0335) 422115',
                'email' => 'smpn3probolinggo@gmail.com',
                'website' => 'https://smpn3probolinggo.sch.id',
                'kepala_sekolah' => 'Rini Agustyowati, S.Pd., M.Pd.',
                'nip_kepala_sekolah' => '197409211999032001',
                'deskripsi' => 'SMP Negeri 3 Probolinggo. Tanggal Berdiri: 7 Januari 1979. Akreditasi: A.',
                'dataset_target' => 45,
            ],
            4 => [
                'id' => 4,
                'nama_sekolah' => 'SMP Negeri 5 Probolinggo',
                'npsn' => '20536270',
                'jenjang' => 'SMP',
                'status_sekolah' => 'Negeri',
                'akreditasi' => 'A',
                'alamat' => 'Jl. HOS Cokroaminoto No. 26, Kanigaran, Kec. Kanigaran, Kota Probolinggo, Jawa Timur 67213',
                'kelurahan' => 'Kanigaran',
                'kecamatan' => 'Kanigaran',
                'kota' => 'Kota Probolinggo',
                'provinsi' => 'Jawa Timur',
                'kode_pos' => '67213',
                'no_telp' => '(0335) 423501',
                'email' => 'smpn5probolinggo@yahoo.com',
                'website' => 'https://smpn5probolinggo.sch.id',
                'kepala_sekolah' => 'David Jonatha Badra, S.Pd., M.M',
                'nip_kepala_sekolah' => '197604182002121004',
                'deskripsi' => 'SMP Negeri 5 Probolinggo. Terakreditasi A, berlokasi di Jl. HOS Cokroaminoto No. 26.',
                'dataset_target' => 52,
            ],
            5 => [
                'id' => 5,
                'nama_sekolah' => 'SMP Negeri 10 Probolinggo',
                'npsn' => '20536274',
                'jenjang' => 'SMP',
                'status_sekolah' => 'Negeri',
                'akreditasi' => 'A',
                'alamat' => 'Jl. Soekarno Hatta No. 263 Q, Tisnonegaran, Kec. Kanigaran, Kota Probolinggo, Jawa Timur 67211',
                'kelurahan' => 'Tisnonegaran',
                'kecamatan' => 'Kanigaran',
                'kota' => 'Kota Probolinggo',
                'provinsi' => 'Jawa Timur',
                'kode_pos' => '67211',
                'no_telp' => '(0335) 438100',
                'email' => 'smpn10kotaprobolinggo@gmail.com',
                'website' => 'https://smpn10probolinggo.sch.id',
                'kepala_sekolah' => 'Aris Tantomas Unggul Pambudi, S.Pd., M.Pd.',
                'nip_kepala_sekolah' => '197911142006041009',
                'deskripsi' => 'SMP Negeri 10 Probolinggo. Terakreditasi A, beralamat di Jl. Soekarno Hatta No. 263 Q.',
                'dataset_target' => 49,
            ],
        ];

        foreach ($sekolahData as $s) {
            $dataInsert = $s;
            unset($dataInsert['dataset_target']);
            $dataInsert['created_at'] = now();
            $dataInsert['updated_at'] = now();
            DB::table('sekolah')->insert($dataInsert);
        }

        // 3. Buat Akun & Data Guru BK (5 Guru BK untuk 5 Sekolah)
        $guruBkConfigs = [
            1 => [
                'username' => 'gurubk_smpn1',
                'nama' => 'Dra. Endang Sri Wahyuni, M.Pd.',
                'nip' => '197508122000032001',
                'gender' => 'P',
                'email' => 'gurubk_smpn1@probolinggo.sch.id',
                'id_sekolah' => 1,
            ],
            2 => [
                'username' => 'gurubk_smpn2',
                'nama' => 'Bambang Hariyadi, S.Pd.',
                'nip' => '198005142005011004',
                'gender' => 'L',
                'email' => 'gurubk_smpn2@probolinggo.sch.id',
                'id_sekolah' => 2,
            ],
            3 => [
                'username' => 'gurubk_smpn3',
                'nama' => 'Siti Nurhaliza, S.Pd., Kons.',
                'nip' => '198311202008012015',
                'gender' => 'P',
                'email' => 'gurubk_smpn3@probolinggo.sch.id',
                'id_sekolah' => 3,
            ],
            4 => [
                'username' => 'gurubk_smpn5',
                'nama' => 'Agus Setiawan, S.Pd.',
                'nip' => '197802102003121002',
                'gender' => 'L',
                'email' => 'gurubk_smpn5@probolinggo.sch.id',
                'id_sekolah' => 4,
            ],
            5 => [
                'username' => 'gurubk_smpn10',
                'nama' => 'Tri Wahyuningsih, S.Psi.',
                'nip' => '198509172009022008',
                'gender' => 'P',
                'email' => 'gurubk_smpn10@probolinggo.sch.id',
                'id_sekolah' => 5,
            ],
        ];

        $guruBkUsers = [];
        foreach ($guruBkConfigs as $sekolahId => $g) {
            $userId = DB::table('users')->insertGetId([
                'username' => $g['username'],
                'email' => $g['email'],
                'password' => Hash::make('password123'),
                'role' => 'gurubk',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('gurubk')->insert([
                'nip' => $g['nip'],
                'id_sekolah' => $g['id_sekolah'],
                'id_pengguna' => $userId,
                'nama' => $g['nama'],
                'gender' => $g['gender'],
                'alamat' => $sekolahData[$sekolahId]['alamat'],
                'no_telp' => '085234' . rand(100000, 999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $guruBkUsers[$sekolahId] = [
                'id_user' => $userId,
                'nip' => $g['nip'],
                'nama' => $g['nama'],
            ];
        }

        // 4. Buat Akun & Data Dinas Sosial (Dinsos)
        $dinsosUserId = DB::table('users')->insertGetId([
            'username' => 'dinsos',
            'email' => 'dinsos@probolinggokota.go.id',
            'password' => Hash::make('password123'),
            'role' => 'dinsos',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('dinsos')->insert([
            'id_dinsos' => 1,
            'id_pengguna' => $dinsosUserId,
            'nip' => '197204151996032003',
            'nama' => 'Dra. Hj. Maimunah, M.Si',
            'gender' => 'P',
            'alamat' => 'Jl. Panglima Sudirman No. 19, Kota Probolinggo',
            'no_telp' => '081234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Buat Akun & Data Siswa Representatif (4 siswa per sekolah = 20 siswa)
        $siswaNames = [
            1 => ['Muhammad Rizky Pratama', 'Aulia Zahra Salsabila', 'Dimas Aditya Nugraha', 'Nabila Putri Kusuma'],
            2 => ['Fajar Hidayatullah', 'Zahra Amelia Ramadhani', 'Kevin Ardiansyah Putra', 'Anindya Tiara Putri'],
            3 => ['Bagus Prasetyo', 'Citra Kirana Lestari', 'Deni Setiawan', 'Eka Rahmawati'],
            4 => ['Galang Permana', 'Hesti Anggraini', 'Ilham Maulana', 'Jelita Novita Sari'],
            5 => ['Kurnia Sandi', 'Lestari Indah Wati', 'Mario Teguh Pradana', 'Nadya Farah Salsabila'],
        ];

        $kelasOptions = ['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'];
        $createdSiswa = [];

        foreach ($siswaNames as $sekolahId => $names) {
            foreach ($names as $idx => $namaSiswa) {
                $username = "siswa_smpn{$sekolahId}_" . ($idx + 1);
                $userId = DB::table('users')->insertGetId([
                    'username' => $username,
                    'email' => "{$username}@siswa.probolinggo.sch.id",
                    'password' => Hash::make('password123'),
                    'role' => 'siswa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $siswaId = DB::table('siswa')->insertGetId([
                    'id_sekolah' => $sekolahId,
                    'id_pengguna' => $userId,
                    'nama' => $namaSiswa,
                    'kelas' => $kelasOptions[array_rand($kelasOptions)],
                    'gender' => ($idx % 2 === 0) ? 'L' : 'P',
                    'alamat' => 'Kota Probolinggo, Jawa Timur',
                    'no_telp' => '0857' . rand(10000000, 99999999),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $createdSiswa[] = [
                    'id_siswa' => $siswaId,
                    'id_pengguna' => $userId,
                    'id_sekolah' => $sekolahId,
                    'nama' => $namaSiswa,
                ];
            }
        }

        // 6. Buat 250 DATASET HISTORIS (2021–2025) Sesuai Permintaan Spesifik:
        // SMPN 1: 59 dataset
        // SMPN 2: 45 dataset
        // SMPN 3: 45 dataset
        // SMPN 5: 52 dataset
        // SMPN 10: 49 dataset
        // Total = 250 dataset historis

        $kasusTemplates = [
            'verbal' => [
                'nama' => ['Ejekan Fisik & Body Shaming', 'Umpatan Kasar & Merendahkan', 'Panggilan Nama Orang Tua Menghina', 'Fitnah & Cemoohan Depan Kelas'],
                'deskripsi' => [
                    'Pelaku melontarkan kata-kata merendahkan kondisi fisik dan keluarga korban secara berulang di lingkungan sekolah saat jam istirahat.',
                    'Korban mendapat ejekan bernada menghina martabat di depan teman sekelas yang menyebabkan korban enggan masuk sekolah.',
                    'Pelontaran umpatan kasar dan kata-kata kotor kepada korban yang memicu perselisihan di area koridor sekolah.',
                ],
                'kata' => 'Umpatan kasar, ejekan bentuk fisik, dan penghinaan keluarga',
            ],
            'fisik' => [
                'nama' => ['Pemukulan dan Pendorongan', 'Pengeroyokan di Area Lapangan', 'Penjambakan & Penendangan', 'Pemaksaan Fisik & Pemalakan'],
                'deskripsi' => [
                    'Korban didorong hingga tersungkur dan dipukul di bagian punggung saat berada di area toilet belakang sekolah.',
                    'Pelaku bersama temannya menghadang korban dan melakukan tindakan fisik serta meminta uang saku korban secara paksa.',
                    'Terjadi perkelahian sepihak di mana korban mengalami lebam pada lengan akibat perlakuan agresif teman sebayanya.',
                ],
                'kata' => 'Ancaman kekerasan, intimidasi fisik langsung, dan paksaan',
            ],
            'sosial' => [
                'nama' => ['Pengucilan Terencana', 'Penyebaran Desas-desus Palsu', 'Penolakan Kelompok Belajar', 'Boikot Sosial di Kelas'],
                'deskripsi' => [
                    'Pelaku mempengaruhi seluruh teman sekelas untuk tidak mengajak korban berbicara dan mengabaikannya selama berhari-hari.',
                    'Penyebaran kabar bohong mengenai kepribadian korban sehingga korban dijauhi oleh seluruh teman satu angkatan.',
                    'Korban dilarang mengikuti kegiatan kelompok dan secara sengaja diasingkan dari pergaulan sosial kelas.',
                ],
                'kata' => 'Fitnah sosial, hasutan untuk memusuhi, dan isolasi sosial',
            ],
            'siber' => [
                'nama' => ['Teror Pesan Media Sosial', 'Penyebaran Foto/Meme Memalukan', 'Komentar Kebencian di Grup Chat', 'Akun Palsu Menghina Korban'],
                'deskripsi' => [
                    'Pelaku membuat postingan menjelek-jelekkan korban di platform media sosial Instagram dan menyebarkan tangkapan layarnya ke grup WhatsApp.',
                    'Korban menerima ancaman dan kata-kata tidak pantas secara anonim melalui pesan langsung media sosial.',
                    'Foto korban diedit menjadi bahan olokan memalukan dan diedarkan di antara sesama siswa tanpa izin.',
                ],
                'kata' => 'Cyber-harassment, cemoohan digital, dan fitnah daring',
            ],
            'seksual' => [
                'nama' => ['Pelecehan Verbal (Catcalling Kasar)', 'Sentuhan Fisik Tanpa Persetujuan', 'Pengiriman Konten Tidak Senonoh', 'Komentar Pelecehan Gender'],
                'deskripsi' => [
                    'Pelaku melontarkan gurauan bernuansa seksual yang melecehkan korban saat berjalan melewati kerumunan siswa.',
                    'Terjadi kontak fisik tidak pantas dan disengaja oleh pelaku yang membuat korban merasa terancam dan trauma berat.',
                    'Pesan bernada pelecehan dikirimkan kepada korban melalui pesan pribadi secara berulang.',
                ],
                'kata' => 'Komentar pelecehan seksual, gurauan tidak pantas, dan intimidasi gender',
            ],
        ];

        $kesimpulanTemplates = [
            'ringan' => [
                'Kasus berhasil diselesaikan melalui sesi bimbingan konseling Guru BK. Pelaku telah meminta maaf secara tulus dan menandatangani surat komitmen untuk tidak mengulangi.',
                'Mediasi ringan antara kedua belah pihak berjalan kondusif. Pemahaman etika pergaulan telah diberikan oleh konselor sekolah.',
            ],
            'sedang' => [
                'Kasus tuntas melalui mediasi formal melibatkan wali murid, Guru BK, dan wali kelas. Pelaku dikenakan sanksi edukatif dan pemantauan perilaku berkala selama 1 bulan.',
                'Tindakan konseling intensif telah dilaksanakan. Pihak sekolah memulihkan hubungan pertemanan dan memberikan pendampingan psikologis kepada korban.',
            ],
            'berat' => [
                'Kasus tuntas ditangani secara terpadu oleh Guru BK bersama Dinas Sosial Kota Probolinggo. Korban menerima pendampingan psikologis trauma healing dan pelaku mendapat pembinaan ketat serta pakta integritas.',
                'Mediasi tingkat sekolah bersama Komite dan perwakilan Dinsos menghasilkan kesepakatan damai dengan sanksi skorsing edukatif bagi pelaku serta pemulihan hak belajar korban secara menyeluruh.',
            ],
        ];

        // Generator Kasus 250 Item
        $caseCounter = 1;
        $allPengaduanIds = [];

        foreach ($sekolahData as $sekolahId => $sInfo) {
            $targetCount = $sInfo['dataset_target'];
            $namaSekolah = $sInfo['nama_sekolah'];
            $guruBkInfo = $guruBkUsers[$sekolahId];

            for ($i = 0; $i < $targetCount; $i++) {
                // Tentukan Tahun (2021 - 2025) secara merata
                $year = 2021 + ($i % 5);
                $month = rand(1, 12);
                $day = rand(1, 28);
                $hour = rand(7, 14);
                $minute = rand(10, 50);

                $createdAt = Carbon::create($year, $month, $day, $hour, $minute, 0);
                $tanggalSelesai = (clone $createdAt)->addDays(rand(5, 25))->addHours(rand(1, 6));

                // Pilih Bentuk Perundungan secara proporsional
                $bentukList = ['verbal', 'verbal', 'fisik', 'fisik', 'sosial', 'siber', 'seksual'];
                $bentuk = $bentukList[array_rand($bentukList)];
                $tpl = $kasusTemplates[$bentuk];

                // Atribut Penentu Keputusan (ID3)
                $frekuensi = match ($i % 3) {
                    0 => 'sekali',
                    1 => '2-3_kali',
                    default => 'sering',
                };

                $pelakuBanyak = ($i % 2 === 1) ? 1 : 0;
                $kontenDigital = ($bentuk === 'siber' || ($bentuk !== 'fisik' && $i % 4 === 0)) ? 1 : 0;
                $lukaFisik = ($bentuk === 'fisik' && ($frekuensi !== 'sekali' || $i % 3 === 0)) ? 1 : 0;
                $traumaMental = ($lukaFisik || $frekuensi === 'sering' || $bentuk === 'seksual' || ($bentuk === 'siber' && $pelakuBanyak)) ? 1 : 0;

                // Tentukan Klasifikasi berdasarkan kaidah ID3 / Clinical Severity
                if ($lukaFisik || ($traumaMental && $frekuensi === 'sering') || ($bentuk === 'seksual' && $traumaMental)) {
                    $klasifikasi = 'berat';
                } elseif ($frekuensi === 'sering' || $traumaMental || ($pelakuBanyak && $frekuensi !== 'sekali') || $bentuk === 'siber') {
                    $klasifikasi = 'sedang';
                } else {
                    $klasifikasi = 'ringan';
                }

                $deskripsiTeks = $tpl['deskripsi'][array_rand($tpl['deskripsi'])];
                $deskripsiFull = "{$deskripsiTeks} Peristiwa terjadi di lingkungan {$namaSekolah} pada tahun {$year} dan telah diarsipkan sebagai rekam jejak bimbingan konseling.";

                $kesimpulanTeks = $kesimpulanTemplates[$klasifikasi][array_rand($kesimpulanTemplates[$klasifikasi])];

                $pelaporName = 'Siswa ' . chr(65 + ($i % 26)) . '. ' . ($i + 1);
                $pelakuName = 'Siswa Terlapor ' . ($i % 15 + 1);

                $kodeKasus = sprintf('HIST-%d-%03d', $year, $caseCounter);

                $pengaduanId = DB::table('pengaduan')->insertGetId([
                    'id_sekolah' => $sekolahId,
                    'kode_kasus' => $kodeKasus,
                    'id_user' => $guruBkInfo['id_user'],
                    'nama_pelaku' => $pelakuName,
                    'nama_pelapor' => $pelaporName,
                    'bentuk_perundungan' => $bentuk,
                    'frekuensi_kejadian' => $frekuensi,
                    'lokasi' => ($bentuk === 'siber' ? 'online' : ($i % 5 === 0 ? 'luar_sekolah' : 'sekolah')),
                    'trauma_mental' => $traumaMental,
                    'luka_fisik' => $lukaFisik,
                    'pelaku_lebih_dari_satu' => $pelakuBanyak,
                    'konten_digital' => $kontenDigital,
                    'jenis_kata' => $tpl['kata'],
                    'klasifikasi' => $klasifikasi,
                    'deskripsi' => $deskripsiFull,
                    'status' => 'selesai',
                    'tahap_penanganan' => 'selesai',
                    'tanggal_selesai' => $tanggalSelesai,
                    'kesimpulan_kasus' => $kesimpulanTeks,
                    'sumber' => 'history',
                    'foto' => null,
                    'created_at' => $createdAt,
                    'updated_at' => $tanggalSelesai,
                ]);

                $allPengaduanIds[] = $pengaduanId;

                // Tambahkan Riwayat Penanganan untuk kasus-kasus pilihan agar audit trail realistis
                if ($i % 2 === 0) {
                    // Tahap 1: Penerimaan
                    DB::table('riwayat_penanganan_kasus')->insert([
                        'id_pengaduan' => $pengaduanId,
                        'id_user' => $guruBkInfo['id_user'],
                        'nama_petugas' => $guruBkInfo['nama'],
                        'peran_petugas' => 'Guru BK',
                        'status_tahap' => 'investigasi',
                        'judul_tindakan' => 'Klarifikasi Fakta & Pemeriksaan Saksi',
                        'catatan' => 'Pemeriksaan keterangan awal bersama korban dan saksi mata di ruang BK.',
                        'rekomendasi' => 'Lanjutkan ke sesi bimbingan konseling dan panggil wali murid.',
                        'created_at' => (clone $createdAt)->addDays(2),
                        'updated_at' => (clone $createdAt)->addDays(2),
                    ]);

                    // Tahap 2: Selesai
                    DB::table('riwayat_penanganan_kasus')->insert([
                        'id_pengaduan' => $pengaduanId,
                        'id_user' => $guruBkInfo['id_user'],
                        'nama_petugas' => $guruBkInfo['nama'],
                        'peran_petugas' => 'Guru BK',
                        'status_tahap' => 'selesai',
                        'judul_tindakan' => 'Penyelesaian Kasus & Penandatanganan Pakta Perdamaian',
                        'catatan' => $kesimpulanTeks,
                        'rekomendasi' => 'Kasus ditutup secara damai. Pemantauan berkala tetap dilakukan.',
                        'created_at' => $tanggalSelesai,
                        'updated_at' => $tanggalSelesai,
                    ]);
                }

                // Tambahkan Feedback Konseling pada beberapa kasus
                if ($i % 4 === 0) {
                    DB::table('feedback')->insert([
                        'id_pengaduan' => $pengaduanId,
                        'nip' => $guruBkInfo['nip'],
                        'id_user' => $guruBkInfo['id_user'],
                        'isi_tanggapan' => "Arahan Guru BK: Kasus {$kodeKasus} telah ditindaklanjuti secara seksama. Siswa diharapkan saling menghormati dan menciptakan suasana belajar yang aman di {$namaSekolah}.",
                        'created_at' => (clone $createdAt)->addDays(3),
                    ]);
                }

                $caseCounter++;
            }
        }

        // 7. Buat Data Survey TAM (Technology Acceptance Model) yang Baru & Positif (30 Responden)
        $surveyNames = [
            'Dra. Endang Sri Wahyuni, M.Pd.', 'Bambang Hariyadi, S.Pd.', 'Siti Nurhaliza, S.Pd., Kons.',
            'Agus Setiawan, S.Pd.', 'Tri Wahyuningsih, S.Psi.', 'Zakial Irfan, S.Pd., M.Pd.',
            'Sandi Purwanto, S.E., M.Pd.', 'Rini Agustyowati, S.Pd., M.Pd.', 'David Jonatha Badra, S.Pd., M.M',
            'Aris Tantomas Unggul Pambudi, S.Pd., M.Pd.', 'Dra. Hj. Maimunah, M.Si', 'Muhammad Rizky Pratama',
            'Aulia Zahra Salsabila', 'Dimas Aditya Nugraha', 'Nabila Putri Kusuma', 'Fajar Hidayatullah',
            'Zahra Amelia Ramadhani', 'Kevin Ardiansyah Putra', 'Anindya Tiara Putri', 'Bagus Prasetyo',
            'Citra Kirana Lestari', 'Deni Setiawan', 'Eka Rahmawati', 'Galang Permana',
            'Hesti Anggraini', 'Ilham Maulana', 'Jelita Novita Sari', 'Kurnia Sandi',
            'Lestari Indah Wati', 'Mario Teguh Pradana',
        ];

        foreach ($surveyNames as $idx => $sName) {
            $linkedPengaduanId = $allPengaduanIds[$idx % count($allPengaduanIds)];
            
            // Variasikan skor Likert secara realistis dan positif (4.00 - 5.00)
            $pu = round(4.2 + (sin($idx) * 0.4) + 0.3, 2);
            $pu = min(5.0, max(3.8, $pu));

            $peou = round(4.1 + (cos($idx) * 0.4) + 0.35, 2);
            $peou = min(5.0, max(3.9, $peou));

            $bi = round(($pu * 0.5) + ($peou * 0.5) + (rand(-10, 10) / 100), 2);
            $bi = min(5.0, max(4.0, $bi));

            DB::table('survey_data')->insert([
                'id_pengaduan' => $linkedPengaduanId,
                'respondent_name' => $sName,
                'email' => strtolower(str_replace([' ', '.', ','], ['', '', ''], $sName)) . '@probolinggo.sch.id',
                'perceived_usefulness' => $pu,
                'perceived_ease_of_use' => $peou,
                'behavioral_intention_to_use' => $bi,
                'created_at' => now()->subDays(30 - $idx),
                'updated_at' => now()->subDays(30 - $idx),
            ]);
        }

        // 8. Latih Ulang Pohon Keputusan (Decision Tree ID3) dengan 250 Dataset Baru
        Cache::forget('active_decision_tree');
        $treeService = app(DecisionTreeService::class);
        $datasetAll = Pengaduan::whereNotNull('klasifikasi')->get();
        if ($datasetAll->count() > 0) {
            $tree = $treeService->buildTree($datasetAll, [
                'bentuk_perundungan',
                'frekuensi_kejadian',
                'trauma_mental',
                'luka_fisik',
                'pelaku_lebih_dari_satu',
                'konten_digital',
            ]);
            Cache::put('active_decision_tree', $tree, now()->addDays(7));
        }
    }
}
