<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('land_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            
            // Status Kepemilikan
            $table->integer('government_owned')->default(0);
            $table->integer('foundation_owned')->default(0);
            $table->integer('individual_owned')->default(0);
            $table->integer('other_owned')->default(0);
            
            // Luas Tanah
            $table->decimal('area_size', 10, 2)->nullable(); // dalam m²
            $table->integer('purchase_year')->nullable();
            
            // Bukti Kepemilikan
            $table->enum('ownership_proof', ['Akte', 'Sertifikat', 'Hibah', 'Wakaf', 'Lainnya'])->nullable();
            $table->string('proof_number')->nullable();
            $table->text('proof_description')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('land_assets');
    }
};