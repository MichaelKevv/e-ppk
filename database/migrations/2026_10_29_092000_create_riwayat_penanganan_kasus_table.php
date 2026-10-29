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
        // 1. Expand status in pengaduan and add progression fields
        if (Schema::hasTable('pengaduan')) {
            // Change status to VARCHAR(50) for maximum flexibility across all workflow stages
            DB::statement("ALTER TABLE pengaduan MODIFY status VARCHAR(50) NOT NULL DEFAULT 'diproses'");

            Schema::table('pengaduan', function (Blueprint $table) {
                if (!Schema::hasColumn('pengaduan', 'tahap_penanganan')) {
                    $table->string('tahap_penanganan', 100)->default('Laporan Diterima')->after('status');
                }
                if (!Schema::hasColumn('pengaduan', 'tanggal_selesai')) {
                    $table->dateTime('tanggal_selesai')->nullable()->after('tahap_penanganan');
                }
                if (!Schema::hasColumn('pengaduan', 'kesimpulan_kasus')) {
                    $table->text('kesimpulan_kasus')->nullable()->after('tanggal_selesai');
                }
            });
        }

        // 2. Create riwayat_penanganan_kasus table
        if (!Schema::hasTable('riwayat_penanganan_kasus')) {
            Schema::create('riwayat_penanganan_kasus', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_pengaduan');
                $table->foreign('id_pengaduan')->references('id_pengaduan')->on('pengaduan')->onDelete('cascade');
                $table->unsignedBigInteger('id_user')->nullable();
                $table->string('nama_petugas', 150)->nullable();
                $table->string('peran_petugas', 50)->nullable();
                $table->string('status_tahap', 50); // investigasi, konseling, mediasi, selesai, ditutup
                $table->string('judul_tindakan', 255);
                $table->text('catatan');
                $table->text('rekomendasi')->nullable();
                $table->string('lampiran', 255)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_penanganan_kasus');

        if (Schema::hasTable('pengaduan')) {
            Schema::table('pengaduan', function (Blueprint $table) {
                if (Schema::hasColumn('pengaduan', 'tahap_penanganan')) {
                    $table->dropColumn('tahap_penanganan');
                }
                if (Schema::hasColumn('pengaduan', 'tanggal_selesai')) {
                    $table->dropColumn('tanggal_selesai');
                }
                if (Schema::hasColumn('pengaduan', 'kesimpulan_kasus')) {
                    $table->dropColumn('kesimpulan_kasus');
                }
            });
        }
    }
};
