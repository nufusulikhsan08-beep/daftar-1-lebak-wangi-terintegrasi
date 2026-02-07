<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('nip')->nullable();
            $table->string('nuptk')->nullable()->unique();
            $table->enum('gender', ['L', 'P']);
            $table->string('religion')->nullable();
            $table->enum('marital_status', ['K', 'TK'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            
            // Pendidikan
            $table->string('education_initial')->nullable();
            $table->string('education_current')->nullable();
            $table->string('major')->nullable();
            
            // Jabatan & Kepangkatan
            $table->enum('position', ['GK', 'G PAI', 'G PJOK', 'OP', 'TU', 'Lainnya']);
            $table->string('position_detail')->nullable();
            $table->date('tmt_cpns')->nullable();
            $table->date('tmt_pns')->nullable();
            $table->date('tmt_school')->nullable();
            $table->string('teaching_class')->nullable();
            $table->string('golongan')->nullable();
            $table->date('tmt_golongan')->nullable();
            
            // Masa Kerja
            $table->integer('mk_school_years')->default(0);
            $table->integer('mk_school_months')->default(0);
            $table->integer('mk_total_years')->default(0);
            $table->integer('mk_total_months')->default(0);
            $table->integer('mk_golongan_years')->default(0);
            $table->integer('mk_golongan_months')->default(0);
            
            // Status Kepegawaian
            $table->enum('employment_status', ['ASN', 'Sukwan']);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
};