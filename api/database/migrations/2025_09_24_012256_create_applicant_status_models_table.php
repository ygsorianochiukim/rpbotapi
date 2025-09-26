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
        Schema::create('applicant_i_status_table', function (Blueprint $table) {
            $table->id('applicant_i_status_id');
            $table->unsignedBigInteger('applicant_i_information_id');
            $table->string('contribution');
            $table->string('pendingapplication');
            $table->string('lockincontract');
            $table->string('motorcycle');
            $table->string('license');
            $table->string('technicalSkills');
            $table->string('question');
            $table->date('dateAvailability');
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
        Schema::dropIfExists('applicant_status_models');
    }
};
