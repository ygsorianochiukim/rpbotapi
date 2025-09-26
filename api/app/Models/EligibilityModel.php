<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EligibilityModel extends Model
{
    protected $table = 'eligibility_i_table';
    protected $primaryKey = 'eligibility_i_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'applicant_i_information_id',
        'eligibility',
        'is_active',
    ];
}
