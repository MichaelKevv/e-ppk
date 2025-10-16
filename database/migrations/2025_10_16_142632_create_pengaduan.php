<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->unsignedBigInteger('id_siswa');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->enum('bentuk_perundungan', ['verbal', 'fisik', 'sosial', 'siber', 'seksual']);
            $table->enum('frekuensi_kejadian', ['sekali', '2-3_kali', 'sering']);
            $table->string('lokasi')->nullable();
            $table->boolean('trauma_mental')->default(false);
            $table->boolean('luka_fisik')->default(false);
            $table->boolean('pelaku_lebih_dari_satu')->default(false);
            $table->boolean('konten_digital')->default(false);
            $table->string('jenis_kata')->nullable();
            $table->enum('klasifikasi', ['ringan', 'sedang', 'berat']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
