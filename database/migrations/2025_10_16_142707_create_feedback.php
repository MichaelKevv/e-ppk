<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('id_feedback');
            $table->unsignedBigInteger('id_pengaduan');
            $table->foreign('id_pengaduan')->references('id_pengaduan')->on('pengaduan')->onDelete('cascade');
            $table->string('nip', 20);
            $table->text('isi_tanggapan');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('nip')->references('nip')->on('gurubk')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
