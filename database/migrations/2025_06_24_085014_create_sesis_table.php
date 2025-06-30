<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sesis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('komputer_id'); 
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai')->nullable(); 
            $table->integer('durasi')->nullable(); 
            $table->timestamps();

            $table->foreign('komputer_id')->references('id')->on('komputers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesis');
    }
};
