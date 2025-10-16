<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dinsos', function (Blueprint $table) {
            $table->string('nip', 20)->primary();
            $table->unsignedBigInteger('id_pengguna');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('users')->onDelete('cascade');
            $table->string('nama', 100);
            $table->enum('gender', ['L', 'P']);
            $table->text('alamat')->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->string('foto', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dinsos');
    }
};
