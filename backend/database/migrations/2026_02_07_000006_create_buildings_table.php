<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            
            // Jenis Ruang
            $table->string('room_type');
            $table->integer('quantity')->default(0);
            
            // Kondisi Bangunan
            $table->integer('condition_non_standard')->default(0);
            $table->integer('condition_good')->default(0);
            $table->integer('condition_light_damage')->default(0);
            $table->integer('condition_medium_damage')->default(0);
            $table->integer('condition_heavy_damage')->default(0);
            
            // Usia Bangunan
            $table->integer('age_le_6')->default(0);   // <= 6 tahun
            $table->integer('age_7')->default(0);
            $table->integer('age_8')->default(0);
            $table->integer('age_9')->default(0);
            $table->integer('age_10')->default(0);
            $table->integer('age_11')->default(0);
            $table->integer('age_12')->default(0);
            $table->integer('age_ge_13')->default(0);  // >= 13 tahun
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buildings');
    }
};