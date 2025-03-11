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

        Schema::create('gambar_ekskul', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ekskul_id');
            $table->string('gambar'); // Menyimpan path gambar
            $table->foreign('ekskul_id')->references('id_ekskul')->on('ekskul')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar_ekskuls');
    }
};
