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
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id("id_jabatan")->primary();
            $table->string("kode_jabatan", 6)->unique();
            $table->string("nama_jabatan", 255);
            $table->unsignedBigInteger('id_ekskul');
            $table->unsignedBigInteger('id_user');
            $table->string("slug", 255)->unique();

            $table->foreignId('id_ekskul')->references('id_ekskul')->on('ekskul');
            $table->foreignId('id_user')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
