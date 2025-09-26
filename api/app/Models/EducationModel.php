<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationModel extends Model
{
    protected $table = 'education_i_information_table';
    protected $primaryKey = 'education_i_information_id';
    public $incrementing = true;
    protected $keyType= 'int';
    protected $fillable = [
        'applicant_i_information_id',
        'college',
        'course',
        'yeargraduate',
        'graduateschool',
        'boardexam',
        'is_active',
    ];

}
