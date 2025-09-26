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
        Schema::create('education_i_information_table', function (Blueprint $table) {
            $table->id('education_i_information_id');
            $table->unsignedBigInteger('applicant_i_information_id');
            $table->string('college');
            $table->string('course');
            $table->integer('yeargraduate');
            $table->integer('graduateschool');
            $table->string('boardexam');
            $table->boolean('is_active');
            $table->timestamps();

            $table->foreign('applicant_i_information_id')->references('applicant_i_information_id')->on('applicant_i_information_table')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_models');
    }
};
