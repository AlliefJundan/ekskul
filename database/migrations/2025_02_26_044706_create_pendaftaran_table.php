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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_ekskul');
            $table->enum('status', ['pending', 'diterima', 'ditolak', 'keluar', 'dikeluarkan']);
            $table->timestamps();

            $table->foreign("id_ekskul")->references("id_ekskul")->on("ekskul")->onDelete("cascade");
            $table->foreign("id_user")->references("id_user")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
