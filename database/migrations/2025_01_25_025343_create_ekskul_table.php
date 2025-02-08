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
        Schema::disableForeignKeyConstraints();

        Schema::create('ekskul', function (Blueprint $table) {
            $table->id("id_ekskul")->primary();
            $table->string("nama_ekskul", 30);
            $table->string("slug", 255)->unique();
            $table->integer("jml_anggota");
            $table->unsignedBigInteger("id_pembina")->nullable();
            $table->unsignedBigInteger("id_ketua")->nullable();
            $table->unsignedBigInteger("id_sekertaris")->nullable();
            $table->unsignedBigInteger("id_bendahara")->nullable();
            $table->integer("jadwal")->nullable();

            $table->foreign("id_pembina")->references("id_jabatan")->on("jabatan");
            $table->foreign("id_ketua")->references("id_jabatan")->on("jabatan");
            $table->foreign("id_sekertaris")->references("id_jabatan")->on("jabatan");
            $table->foreign("id_bendahara")->references("id_jabatan")->on("jabatan");
        });



        Schema::enableForeignKeyConstraints();
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekskul');
    }
};
