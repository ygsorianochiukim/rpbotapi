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
        Schema::create('work_i_information_table', function (Blueprint $table) {
            $table->id('work_i_information_id');
            $table->unsignedBigInteger('applicant_i_information_id');
            $table->string('companyname');
            $table->string('workduration');
            $table->string('reasonforleaving');
            $table->string('position');
            $table->integer('previouscompensation');
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
        Schema::dropIfExists('work_models');
    }
};
