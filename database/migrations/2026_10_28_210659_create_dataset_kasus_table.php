<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dataset_kasus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kasus', 50)->nullable();
            $table->enum('bentuk_perundungan', ['verbal', 'fisik', 'sosial', 'siber', 'seksual']);
            $table->enum('frekuensi_kejadian', ['sekali', '2-3_kali', 'sering']);
            $table->boolean('trauma_mental')->default(false);
            $table->boolean('luka_fisik')->default(false);
            $table->boolean('pelaku_lebih_dari_satu')->default(false);
            $table->boolean('konten_digital')->default(false);
            $table->enum('klasifikasi', ['ringan', 'sedang', 'berat']);
            $table->enum('sumber', ['history', 'pengaduan'])->default('history');
            $table->unsignedBigInteger('id_pengaduan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_kasus');
    }
};
