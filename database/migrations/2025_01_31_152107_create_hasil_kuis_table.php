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
        Schema::create('hasil_kuis', function (Blueprint $table) {
            $table->id("id_hasil"); // No need for ->primary()
            $table->unsignedBigInteger("id_kuis");
            $table->unsignedBigInteger("id_user");
            $table->unsignedBigInteger("id_ekskul");
            $table->string("skor");
            $table->string("bukti");
            $table->timestamps();

            $table->foreign("id_kuis")->references("id_kuis")->on("kuis");
            $table->foreign("id_ekskul")->references("id_ekskul")->on("ekskul");
            $table->foreign("id_user")->references("id_user")->on("users"); // Fixed column name
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_kuis');
    }
};
