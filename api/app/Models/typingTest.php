<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class typingTest extends Model
{
    protected $table = 'appicant_i_typing_text_table';
    protected $primaryKey = 'appicant_i_typing_text_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'applicant_i_information_id',
        'wpm',
        'accuracy',
        'is_active',
    ];
}
