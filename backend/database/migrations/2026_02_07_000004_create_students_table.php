<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('nis')->unique()->nullable();
            $table->string('nisn')->nullable();
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->enum('class', ['I', 'II', 'III', 'IV', 'V', 'VI']);
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('address')->nullable();
            
            // Data Orang Tua
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('guardian_name')->nullable();
            
            // Kondisi Ekonomi
            $table->enum('economic_status', ['Mampu', 'Sedang', 'Tidak Mampu'])->default('Sedang');
            
            // Status Siswa
            $table->enum('status', ['Aktif', 'Pindah', 'Dropout', 'Lulus'])->default('Aktif');
            $table->date('entry_date')->nullable(); // Tanggal masuk
            $table->date('exit_date')->nullable();  // Tanggal keluar (jika pindah/dropout)
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};