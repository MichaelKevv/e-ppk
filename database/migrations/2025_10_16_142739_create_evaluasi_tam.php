<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluasi_tam', function (Blueprint $table) {
            $table->id('id_evaluasi');
            $table->unsignedBigInteger('id_pengguna');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('users')->onDelete('cascade');
            $table->integer('perceived_usefulness');
            $table->integer('perceived_ease_of_use');
            $table->integer('intention_to_use');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasi_tam');
    }
};
