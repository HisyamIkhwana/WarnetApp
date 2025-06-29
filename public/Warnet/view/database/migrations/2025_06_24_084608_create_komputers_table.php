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
        Schema::create('komputers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warnet_id'); // Relasi ke Warnet
            $table->string('merk');
            $table->string('spesifikasi');
            $table->boolean('status')->default(true); // Status aktif/nonaktif
            $table->timestamps();

            $table->foreign('warnet_id')->references('id')->on('warnets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komputers');
    }
};
