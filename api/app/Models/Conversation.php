<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversation_table';
    protected $primaryKey = 'applicant_i_conversation_id';
    public $incrementing = true;
    protected $keyType= 'int';
    protected $fillable = [
        'applicant_i_information_id',
        'messages',
        'care',
        'ambition',
        'influence',
        'skillsDevelopment',
        'technicalSkills',
        'discipline',
        'commentary',
    ];

    protected $casts = [
        'messages' => 'array',
    ];
}
