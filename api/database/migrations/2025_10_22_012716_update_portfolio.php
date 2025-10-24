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
        Schema::table('applicant_i_status_table', function (Blueprint $table) {
            $table->string('potfolio_link')->nullable();
            $table->string('filename')->nullable();
            $table->longText('file_content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_i_status_table', function (Blueprint $table) {
            //
        });
    }
};
