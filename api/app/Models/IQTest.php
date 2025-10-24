<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IQTest extends Model
{
    protected $table = 'applicant_iq_table';
    protected $primaryKey = 'applicant_iq_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'applicant_i_information_id',
        'score',
        'is_active',
    ];
}
