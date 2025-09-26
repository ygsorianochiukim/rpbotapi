<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarriageModel extends Model
{
    protected $table ='marriage_i_information_table';
    protected $primaryKey = 'marriage_i_information_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'applicant_i_information_id',
        'partnerReligion',
        'dateMarried',
        'child',
        'numberofchildren',
        'ageofchildren',
        'guardianofchildren',
        'is_active',
    ];
}
