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
        Schema::create('kuis', function (Blueprint $table) {
            $table->id("id_kuis")->primary();
            $table->string("nama_kuis", 30);
            $table->string("isi_kuis");
            $table->unsignedBigInteger("id_ekskul");

            $table->foreign("id_ekskul")->references("id_ekskul")->on("ekskul");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuis');
    }
};
