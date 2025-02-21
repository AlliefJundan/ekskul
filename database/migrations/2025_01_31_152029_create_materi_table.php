<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materi', function (Blueprint $table) {
            $table->id("id_materi");
            $table->unsignedBigInteger("id_ekskul");
            $table->unsignedBigInteger("id_user");
            $table->text("isi_materi");
            $table->string("lampiran_materi")->nullable();
            $table->timestamps();

            $table->foreign("id_ekskul")->references("id_ekskul")->on("ekskul")->onDelete("cascade");
            $table->foreign("id_user")->references("id_user")->on("users")->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
