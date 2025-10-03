<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantModel extends Model
{
    protected $table = 'applicant_i_information_table';

    protected $primaryKey = 'applicant_i_information_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'email',
        'civilStatus',
        'contactnumber',
        'birthdate',
        'religion',
        'province',
        'cities',
        'barangay',
        'zipcode',
        'expectedSalary',
        'is_active',
        'blood_type',
        'gender',
        'nickname',
    ];
}
