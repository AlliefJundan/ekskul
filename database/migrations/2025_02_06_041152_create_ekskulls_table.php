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
        Schema::create('ekskulls', function (Blueprint $table) {
            $table->string('nama_ekskul');
            $table->string('nama_pembina')->nullable();
            $table->string('nama_ketua')->nullable();
            $table->integer('jml_anggota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekskulls');
    }
};
