<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantInterviewModel extends Model
{
    protected $table = 'applicant_i_interview_table';
    protected $primaryKey = 'applicant_i_interview_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'applicant_i_information_id',
        'interview_url',
        'interview_id',
        'verdict',
        'verdict_at',
        'verdict_by',
        'verdict_note',
        'verdict_ref',
        'language',
        'sms_sent_at',
        'sms_response',
    ];

    protected $casts = [
        'verdict_at' => 'datetime',
        'sms_sent_at' => 'datetime',
    ];
}
