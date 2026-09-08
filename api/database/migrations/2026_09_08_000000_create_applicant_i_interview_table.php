<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// The interview no longer happens in this portal. After the exams the
// applicant is handed to the Approvals desk, which runs the interview and
// where the MD releases a verdict. This table holds the two things that cross
// that seam: the link the applicant was sent to, and the verdict that came
// back. Scores, commentary and transcripts never land here.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applicant_i_interview_table', function (Blueprint $table) {
            $table->id('applicant_i_interview_id');
            $table->unsignedBigInteger('applicant_i_information_id')->unique();
            $table->string('interview_url')->nullable();      // the one-time link on Approvals
            $table->unsignedBigInteger('interview_id')->nullable(); // Approvals' own id for it
            $table->string('verdict', 20)->default('pending'); // pending | passed | failed
            $table->timestamp('verdict_at')->nullable();
            $table->string('verdict_by')->nullable();
            $table->text('verdict_note')->nullable();
            $table->string('verdict_ref')->nullable();        // points back to the full record on Approvals
            $table->string('language', 20)->nullable();       // the language the interview ran in
            $table->timestamp('sms_sent_at')->nullable();
            $table->text('sms_response')->nullable();
            $table->timestamps();

            $table->foreign('applicant_i_information_id')
                ->references('applicant_i_information_id')
                ->on('applicant_i_information_table')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicant_i_interview_table');
    }
};
