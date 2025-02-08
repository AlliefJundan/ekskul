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
            $table->id("id_jabatan"); // Primary Key
            $table->string("kode_jabatan", 6)->unique();
            $table->string("nama_jabatan", 255);
            $table->unsignedBigInteger('id_ekskul'); // Foreign Key
            $table->unsignedBigInteger('id_user'); // Foreign Key
            $table->string("slug", 255)->unique();

            // Menambahkan foreign key constraint
            $table->foreign('id_ekskul')->references('id_ekskul')->on('ekskul')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
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
