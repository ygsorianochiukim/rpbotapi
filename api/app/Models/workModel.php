<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class workModel extends Model
{
    protected $table = 'work_i_information_table';
    protected $primaryKey = 'work_i_information_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'applicant_i_information_id',
        'companyname',
        'workduration',
        'reasonforleaving',
        'position',
        'previouscompensation',
        'is_active',
    ];
}
