<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id('id_artikel');
            $table->unsignedBigInteger('author');
            $table->foreign('author')->references('id_admin')->on('admin')->onDelete('cascade');
            $table->string('judul', 200);
            $table->text('konten');
            $table->string('kategori', 100);
            $table->string('gambar', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
