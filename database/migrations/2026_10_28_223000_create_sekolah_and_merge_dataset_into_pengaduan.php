<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create sekolah table
        if (!Schema::hasTable('sekolah')) {
            Schema::create('sekolah', function (Blueprint $table) {
                $table->id();
                $table->string('npsn', 20)->nullable()->unique();
                $table->string('nama_sekolah', 255);
                $table->string('jenjang', 50)->default('SMP');
                $table->string('status_sekolah', 50)->default('Negeri');
                $table->string('akreditasi', 10)->default('A');
                $table->text('alamat')->nullable();
                $table->string('kelurahan', 100)->nullable();
                $table->string('kecamatan', 100)->nullable();
                $table->string('kota', 100)->nullable();
                $table->string('provinsi', 100)->nullable();
                $table->string('kode_pos', 10)->nullable();
                $table->string('no_telp', 30)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('website', 150)->nullable();
                $table->string('kepala_sekolah', 150)->nullable();
                $table->string('nip_kepala_sekolah', 50)->nullable();
                $table->string('logo', 255)->nullable();
                $table->text('deskripsi')->nullable();
                $table->timestamps();
            });

            // Insert default school data
            DB::table('sekolah')->insert([
                'id' => 1,
                'npsn' => '20104050',
                'nama_sekolah' => 'SMP Negeri 1 Ramah Anak Lapora',
                'jenjang' => 'SMP',
                'status_sekolah' => 'Negeri',
                'akreditasi' => 'A',
                'alamat' => 'Jl. Pendidikan Merdeka No. 45',
                'kelurahan' => 'Kuningan',
                'kecamatan' => 'Setiabudi',
                'kota' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '12940',
                'no_telp' => '(021) 5251234',
                'email' => 'info@smpn1lapora.sch.id',
                'website' => 'https://smpn1lapora.sch.id',
                'kepala_sekolah' => 'Dra. Hj. Nuraini M.Pd.',
                'nip_kepala_sekolah' => '197508122000032001',
                'deskripsi' => 'Sekolah percontohan ramah anak dengan komitmen nol toleransi terhadap perundungan dan kekerasan di lingkungan pendidikan.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Add id_sekolah to siswa
        if (Schema::hasTable('siswa') && !Schema::hasColumn('siswa', 'id_sekolah')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->unsignedBigInteger('id_sekolah')->nullable()->after('id_siswa');
                $table->foreign('id_sekolah')->references('id')->on('sekolah')->onDelete('set null');
            });

            // Associate existing siswa to default school
            DB::table('siswa')->update(['id_sekolah' => 1]);
        }

        // 3. Add id_sekolah to gurubk
        if (Schema::hasTable('gurubk') && !Schema::hasColumn('gurubk', 'id_sekolah')) {
            Schema::table('gurubk', function (Blueprint $table) {
                $table->unsignedBigInteger('id_sekolah')->nullable()->after('nip');
                $table->foreign('id_sekolah')->references('id')->on('sekolah')->onDelete('set null');
            });
        }

        // 4. Update pengaduan table
        if (Schema::hasTable('pengaduan')) {
            Schema::table('pengaduan', function (Blueprint $table) {
                if (!Schema::hasColumn('pengaduan', 'id_sekolah')) {
                    $table->unsignedBigInteger('id_sekolah')->nullable()->after('id_pengaduan');
                    $table->foreign('id_sekolah')->references('id')->on('sekolah')->onDelete('set null');
                }
                if (!Schema::hasColumn('pengaduan', 'kode_kasus')) {
                    $table->string('kode_kasus', 50)->nullable()->after('id_pengaduan');
                }
                if (!Schema::hasColumn('pengaduan', 'sumber')) {
                    $table->enum('sumber', ['pengaduan', 'history'])->default('pengaduan')->after('status');
                }
            });

            // Modify columns in pengaduan to be nullable using raw DB statement for mysql/mariadb compatibility
            DB::statement("ALTER TABLE pengaduan MODIFY id_user BIGINT(20) UNSIGNED NULL");
            DB::statement("ALTER TABLE pengaduan MODIFY nama_pelaku VARCHAR(255) NULL");
            DB::statement("ALTER TABLE pengaduan MODIFY deskripsi TEXT NULL");
            DB::statement("ALTER TABLE pengaduan MODIFY status ENUM('diproses', 'selesai', 'ditutup', 'history') NOT NULL DEFAULT 'diproses'");
        }

        // 5. Migrate data from dataset_kasus if exists
        if (Schema::hasTable('dataset_kasus')) {
            $cases = DB::table('dataset_kasus')->get();
            foreach ($cases as $c) {
                DB::table('pengaduan')->insert([
                    'id_sekolah' => 1,
                    'kode_kasus' => $c->kode_kasus ?? ('KASUS-' . sprintf('%03d', $c->id)),
                    'id_user' => null,
                    'nama_pelaku' => 'Dataset Historis',
                    'nama_pelapor' => 'Arsip Kasus Sekolah',
                    'bentuk_perundungan' => $c->bentuk_perundungan,
                    'frekuensi_kejadian' => $c->frekuensi_kejadian,
                    'lokasi' => 'Lingkungan Sekolah',
                    'trauma_mental' => $c->trauma_mental,
                    'luka_fisik' => $c->luka_fisik,
                    'pelaku_lebih_dari_satu' => $c->pelaku_lebih_dari_satu,
                    'konten_digital' => $c->konten_digital,
                    'jenis_kata' => null,
                    'klasifikasi' => $c->klasifikasi,
                    'deskripsi' => 'Data historis kasus perundungan untuk pelatihan model Decision Tree (ID3).',
                    'status' => 'history',
                    'sumber' => 'history',
                    'foto' => null,
                    'created_at' => $c->created_at ?? now(),
                    'updated_at' => $c->updated_at ?? now(),
                ]);
            }

            // Drop redundant dataset_kasus table
            Schema::dropIfExists('dataset_kasus');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pengaduan')) {
            Schema::table('pengaduan', function (Blueprint $table) {
                if (Schema::hasColumn('pengaduan', 'id_sekolah')) {
                    $table->dropForeign(['id_sekolah']);
                    $table->dropColumn('id_sekolah');
                }
                if (Schema::hasColumn('pengaduan', 'kode_kasus')) {
                    $table->dropColumn('kode_kasus');
                }
                if (Schema::hasColumn('pengaduan', 'sumber')) {
                    $table->dropColumn('sumber');
                }
            });
        }

        if (Schema::hasTable('gurubk') && Schema::hasColumn('gurubk', 'id_sekolah')) {
            Schema::table('gurubk', function (Blueprint $table) {
                $table->dropForeign(['id_sekolah']);
                $table->dropColumn('id_sekolah');
            });
        }

        if (Schema::hasTable('siswa') && Schema::hasColumn('siswa', 'id_sekolah')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->dropForeign(['id_sekolah']);
                $table->dropColumn('id_sekolah');
            });
        }

        Schema::dropIfExists('sekolah');
    }
};
