<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('npsn')->unique();
            $table->string('nss')->nullable();
            $table->string('name');
            $table->enum('status', ['negeri', 'swasta']);
            $table->string('accreditation')->nullable();
            $table->text('address');
            $table->string('village')->nullable();
            $table->string('district')->default('Lebak Wangi');
            $table->string('regency')->default('Serang');
            $table->string('province')->default('Banten');
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schools');
    }
};