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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->enum('kelas', ['10', '11', '12'])->unique();
            $table->enum('jurusan', ['PPLG', 'DKV', 'AKT', 'ANM', 'BDP'])->unique();
            $table->enum('nomor_kelas', ['1', '2', '3'])->unique();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username', 30)->unique();
            $table->string('password', 35);
            $table->string('nama', 25)->unique();
            $table->unsignedBigInteger('id_kelas')->nullable();
            $table->integer('id_ekskul')->nullable();
            $table->integer('id_jabatan')->nullable();
            $table->enum('role', ['admin', 'user']);

            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('sessions');
    }
};
