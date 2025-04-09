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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->string('title');
            $table->enum('category', ['materi', 'pendaftaran', 'kuis', 'kegiatan', 'diterima', 'ditolak', 'dikeluarkan', 'keluar', 'lainya']);
            $table->unsignedBigInteger('id_ekskul')->nullable();
            $table->text('description');
            $table->timestamps();

            $table->foreign('id_ekskul')->references('id_ekskul')->on('ekskul');
        });

        Schema::create('notifikasi_target', function (Blueprint $table) {
            $table->id('id_target');
            $table->unsignedBigInteger('id_notifikasi');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('id_notifikasi')->references('id_notifikasi')->on('notifikasi');
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('notifikasi_target');
    }
};
