<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('principals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('nip')->unique();
            $table->string('nuptk')->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->string('religion')->nullable();
            $table->enum('marital_status', ['K', 'TK']);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('education_initial')->nullable(); // Ijazah awal PNS
            $table->string('education_current')->nullable(); // Ijazah sekarang
            $table->string('major')->nullable(); // Jurusan
            $table->string('rank')->nullable(); // Pangkat
            $table->string('golongan')->nullable();
            $table->date('tmt_golongan')->nullable();
            $table->date('tmt_cpns')->nullable();
            $table->date('tmt_pns')->nullable();
            $table->date('tmt_school')->nullable(); // TMT di sekolah ini
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('principals');
    }
};