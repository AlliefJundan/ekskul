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
        Schema::create('ekskul_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ekskul_id');
            $table->unsignedBigInteger('jabatan')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('ekskul_id')->references('id_ekskul')->on('ekskul')->onDelete('cascade');
            $table->foreign('jabatan')->references('id_jabatan')->on('jabatan')->onDelete('cascade');

            // Unique Constraint (ekskul_id + jabatan)
            $table->unique(['ekskul_id', 'jabatan'], 'unique_ekskul_jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekskul_user');
    }
};
