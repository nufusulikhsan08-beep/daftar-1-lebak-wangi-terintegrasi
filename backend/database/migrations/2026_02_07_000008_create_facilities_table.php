<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            
            // Air Bersih & WC
            $table->boolean('water_well')->default(false);
            $table->boolean('water_pump')->default(false);
            $table->boolean('pam')->default(false);
            $table->boolean('river')->default(false);
            $table->boolean('other_water')->default(false);
            $table->string('other_water_desc')->nullable();
            
            $table->integer('toilet_count')->default(0);
            
            // Status Menumpang
            $table->boolean('is_borrowed')->default(false);
            $table->string('borrowed_from')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facilities');
    }
};