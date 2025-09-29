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
        Schema::create('conversation_table', function (Blueprint $table) {
            $table->id('applicant_i_conversation_id');
            $table->unsignedBigInteger('applicant_i_information_id');
            $table->json('messages'); 
            $table->timestamps();

            $table->foreign('applicant_i_information_id')->references('applicant_i_information_id')->on('applicant_i_information_table')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
