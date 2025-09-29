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
        Schema::table('conversation_table', function (Blueprint $table) {
            $table->integer('care')->nullable();
            $table->integer('mastery')->nullable();
            $table->integer('discipline')->nullable();
            $table->string('commentary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversation_table', function (Blueprint $table) {
            //
        });
    }
};
