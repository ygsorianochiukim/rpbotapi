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
        'desiredPosition',
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
    public function education()
    {
        return $this->hasOne(EducationModel::class, 'applicant_i_information_id');
    }

    public function eligibility()
    {
        return $this->hasOne(EligibilityModel::class, 'applicant_i_information_id');
    }

    public function marriage()
    {
        return $this->hasOne(MarriageModel::class, 'applicant_i_information_id');
    }

    public function work()
    {
        return $this->hasMany(WorkModel::class, 'applicant_i_information_id');
    }

    public function status()
    {
        return $this->hasOne(ApplicantStatusModel::class, 'applicant_i_information_id');
    }
}
