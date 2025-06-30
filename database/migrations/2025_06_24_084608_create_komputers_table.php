<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('komputers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warnet_id'); 
            $table->string('merk');
            $table->string('spesifikasi');
            $table->boolean('status')->default(true); 
            $table->timestamps();

            $table->foreign('warnet_id')->references('id')->on('warnets')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('komputers');
    }
};
