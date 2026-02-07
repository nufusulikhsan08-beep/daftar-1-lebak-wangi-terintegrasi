<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('furniture', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->integer('quantity')->default(0);
            
            // Kondisi
            $table->integer('condition_good')->default(0);
            $table->integer('condition_medium')->default(0);
            $table->integer('condition_light_damage')->default(0);
            $table->integer('condition_heavy_damage')->default(0);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('furniture');
    }
};