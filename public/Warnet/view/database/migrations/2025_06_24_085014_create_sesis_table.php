<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sesis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('komputer_id'); // Relasi ke Komputer
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai')->nullable(); // Nullable karena sesi bisa aktif
            $table->integer('durasi')->nullable(); // Durasi dalam menit
            $table->timestamps();

            $table->foreign('komputer_id')->references('id')->on('komputers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesis');
    }
};
