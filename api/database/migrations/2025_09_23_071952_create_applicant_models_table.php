<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** 
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applicant_i_information_table', function (Blueprint $table) {
            $table->id('applicant_i_information_id');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('civilStatus');
            $table->string('contactnumber');
            $table->date('birthdate');
            $table->string('religion');
            $table->string('province');
            $table->string('cities');
            $table->string('barangay');
            $table->integer('zipcode');
            $table->integer('expectedSalary');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('applicant_models');
    }
};
