<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            
            // Periode
            $table->enum('month', [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ]);
            $table->integer('year');
            
            // Absensi Siswa
            $table->integer('student_absent_sick')->default(0);
            $table->integer('student_absent_permit')->default(0);
            $table->integer('student_absent_alpha')->default(0);
            $table->integer('student_absent_total')->default(0);
            
            // Absensi Guru ASN
            $table->integer('teacher_absent_sick')->default(0);
            $table->integer('teacher_absent_permit')->default(0);
            $table->integer('teacher_absent_alpha')->default(0);
            $table->integer('teacher_absent_total')->default(0);
            
            // Absensi Guru Sukwan
            $table->integer('non_pns_absent_sick')->default(0);
            $table->integer('non_pns_absent_permit')->default(0);
            $table->integer('non_pns_absent_alpha')->default(0);
            $table->integer('non_pns_absent_total')->default(0);
            
            // Hari Efektif
            $table->integer('effective_days')->default(0);
            
            // Perubahan Siswa Bulanan
            $table->json('student_changes')->nullable(); // JSON untuk perubahan per kelas
            
            // Status Laporan
            $table->enum('status', ['draft', 'submitted', 'approved'])->default('draft');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('monthly_reports');
    }
};