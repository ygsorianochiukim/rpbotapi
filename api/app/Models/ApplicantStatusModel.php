<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantStatusModel extends Model
{
    protected $table = 'applicant_i_status_table';
    protected $primaryKey = 'applicant_i_status_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'applicant_i_information_id',
        'pendingapplication',
        'lockincontract',
        'motorcycle',
        'license',
        'technicalSkills',
        'question',
        'is_active',
    ];
}
