<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id("id_absensi");
            $table->unsignedBigInteger("id_ekskul");
            $table->unsignedBigInteger("id_user");
            $table->date("tanggal");
            $table->enum("kehadiran", ["hadir", "izin", "sakit", "alpa"]);
            $table->enum("status", ["terverifikasi", "belum terverifikasi"]);
            $table->timestamps();

            $table->foreign("id_ekskul")->references("id_ekskul")->on("ekskul")->onDelete('cascade');
            $table->foreign("id_user")->references("id_user")->on("users")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
