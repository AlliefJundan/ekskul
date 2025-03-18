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
        Schema::create('ekskul', function (Blueprint $table) {
            $table->id("id_ekskul");
            $table->string("nama_ekskul", 30);
            $table->string("slug", 255)->unique();
            $table->integer("jml_anggota")->default(0);
            $table->text('deskripsi')->nullable();
            $table->string("gambar")->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekskul');
    }
};
